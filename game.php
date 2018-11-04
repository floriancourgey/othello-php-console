<?php
require_once('othello_lib.php');

/** @return int */
function strategy_ask($player, $board){
  echo 'Enter your move, between 11 and 88: ';
  $move = intval(trim(fgets(STDIN)));
  if (!is_valid($move) || !is_legal($move, $player, $board)){
    echo "Invalid move ($move), play again.\n";
    return strategy_ask($player, $board);
  }
  return $move;
}
/** @return int */
function strategy_random($player, $board){
  $legal_moves = legal_moves($player, $board);
  return $legal_moves[array_rand($legal_moves)];
}

function play($black_strategy, $white_strategy){
  $board = initial_board();
  $player = FIRST_TO_PLAY;
  $ply = 0;
  while($player){
    $ply++;
    echo "- Ply $ply\n";
    echo print_score($board);
    echo print_board($board);
    echo RENDER_TYPES_HUMAN[$player]." to play. Available moves: ";
    echo '['.join(', ', legal_moves($player, $board))."]\n";
    $strategy = ($player == TYPE_BLACK) ? $black_strategy : $white_strategy;
    $move = $strategy($player, $board);
    make_move($move, $player, $board);
    echo RENDER_TYPES_HUMAN[$player]." played $move\n\n";
    $player = next_player($board, $player);
  }
  $score = score($board);
  echo ">>> Game over, ";
  if($score[TYPE_BLACK]>$score[TYPE_WHITE]){
    echo RENDER_TYPES_HUMAN[TYPE_BLACK]." wins!\n";
  } elseif($score[TYPE_BLACK]<$score[TYPE_WHITE]){
    echo RENDER_TYPES_HUMAN[TYPE_WHITE]." wins!\n";
  } else {
    echo "it's a tie!!\n";
  }
  echo print_score($board);
  echo "Final board:\n";
  echo print_board($board);
}
/** @return string */
function print_board($board){
  $res = '';
  $res .= '    '.join('  ', range(1, 8))."\n";
  foreach (range(1, 8) as $j) {
    $res .= $j.'0 ';
    foreach (range(1, 8) as $i) {
      $square = $board[$j*10+$i];
      if($square == TYPE_EMPTY){
        // $res .= "$j$i ";
        $res .= ' '.RENDER_TYPES_ASCII[TYPE_EMPTY].' ';
      } else {
        $res .= ' '.RENDER_TYPES_ASCII[$square].' ';
      }
    }
    $res .= "\n";
  }
  return $res;
}
/** @return string */
function print_score($board){
  $score = score($board);
  $res = 'Score: ';
  $res .= '['.RENDER_TYPES_ASCII[TYPE_BLACK].'='.$score[TYPE_BLACK];
  $res .= ' '.RENDER_TYPES_ASCII[TYPE_WHITE].'='.$score[TYPE_WHITE];
  $diff = $score[TYPE_BLACK]-$score[TYPE_WHITE];
  if($diff>0){
    $diff = '+'.$diff;
  }
  $res .= ' ('.$diff.")]\n";
  return $res;
}

$strategies = ['strategy_ask', 'strategy_random'];
shuffle($strategies);
play($strategies[0], $strategies[1]);

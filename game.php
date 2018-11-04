<?php
require_once('othello.php');

function strategy_ask($player, $board){
  echo 'Enter your move, between 11 and 88: ';
  $move = intval(trim(fgets(STDIN)));
  if (!is_valid($move) || !is_legal($move, $player, $board)){
    echo "Invalid move ($move), play again.\n";
    return strategy_ask($player, $board);
  }
  return $move;
}

function strategy_random($player, $board){
  $legal_moves = legal_moves($player, $board);
  return $legal_moves[array_rand($legal_moves)];
}

function play($black_strategy, $white_strategy){
  $board = initial_board();
  $player = FIRST_TO_PLAY;
  while($player){
    echo print_board($board);
    echo RENDER_TYPES_HUMAN[$player]." to play. Available moves: ";
    echo '['.join(', ', legal_moves($player, $board))."]\n";
    $strategy = ($player == TYPE_BLACK) ? $black_strategy : $white_strategy;
    $move = $strategy($player, $board);
    make_move($move, $player, $board);
    echo RENDER_TYPES_HUMAN[$player]." played $move\n\n";
    $player = next_player($board, $player);
  }
  echo "Game over, final board:\n";
  echo print_board($board);
}

function next_player($board, $prev_player){
  $opponent = opponent($prev_player);
  if(any_legal_move($opponent, $board)){
    return $opponent;
  } elseif(any_legal_move($prev_player, $board)){
    return $prev_player;
  }
  return;
}

$strategies = ['strategy_ask', 'strategy_random'];
shuffle($strategies);
play($strategies[0], $strategies[1]);

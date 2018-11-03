<?php
define('TYPE_EMPTY', 0);
define('TYPE_BLACK', 1);
define('TYPE_WHITE', 2);
define('TYPE_OUTER', 3);
define('RENDER_TYPES_ASCII', '.@o?');
define('RENDER_TYPES_HUMAN', [1=>'Black', 2=>'White']);
define('PLAYABLE_TYPES', [TYPE_BLACK, TYPE_WHITE]);
define('FIRST_TO_PLAY', TYPE_BLACK);
define('ALL_DIRECTIONS', [
  -11, -10,  -9,
   -1,        1,
    9,  10,  11,
]);
define('ALL_SQUARES', array_filter(range(11, 88), function($var){return ($var%10>=1) && ($var%10<=8);}) );
function opponent($type){return $type == TYPE_BLACK ? TYPE_WHITE : TYPE_BLACK; }
function is_valid($i){return is_int($i) && in_array($i, ALL_SQUARES);}
function initial_board(){
  $board = array_fill(0, 100, TYPE_OUTER);
  foreach (ALL_SQUARES as $i) {
    $board[$i] = TYPE_EMPTY;
  }
  $board[44] = TYPE_WHITE;
  $board[45] = TYPE_BLACK;
  $board[54] = TYPE_BLACK;
  $board[55] = TYPE_WHITE;
  return $board;
}
function print_board($board){
  $res = '';
  $res .= '    '.join('  ', range(1, 8))."\n";
  foreach (range(1, 8) as $j) {
    $res .= $j.'0 ';
    foreach (range(1, 8) as $i) {
      $square = $board[$j*10+$i];
      if($square == TYPE_EMPTY){
        $res .= "$j$i ";
      } else {
        $res .= ' '.RENDER_TYPES_ASCII[$square].' ';
      }
    }
    $res .= "\n";
  }
  return $res;
}
/** find outer square of a given square @return int|null */
function find_bracket($square, $player, $board, $direction){
  $bracket = $square + $direction;
  if($board[$bracket] == $player){
    return;
  }
  $opponent = opponent($player);
  while($board[$bracket] == $opponent){
    $bracket += $direction;
  }
  if(in_array($board[$bracket], [TYPE_OUTER, TYPE_EMPTY])){
    return;
  }
  return $bracket;
}
function is_legal($square, $player, $board){
  if($board[$square] != TYPE_EMPTY){
    return false;
  }
  foreach (ALL_DIRECTIONS as $direction) {
    $bracket = find_bracket($square, $player, $board, $direction);
    if($bracket){
      return true;
    }
  }
  return false;
}
function legal_moves($player, $board){
  $legal_moves = [];
  foreach (ALL_SQUARES as $sq) {
    if(is_legal($sq, $player, $board)){
      $legal_moves[] = $sq;
    }
  }
  return $legal_moves;
}
function any_legal_move($player, $board){
  foreach (ALL_SQUARES as $square) {
    if(is_legal($square, $player, $board)){
      return true;
    }
  }
  return false;
}
function make_move($square, $player, &$board){
  $board[$square] = $player;
  foreach (ALL_DIRECTIONS as $direction) {
    make_flips($square, $player, $board, $direction);
  }
  return $board;
}
function make_flips($square, $player, &$board, $direction){
  $bracket = find_bracket($square, $player, $board, $direction);
  if(!$bracket){
    return;
  }
  $square = $square + $direction;
  while($square != $bracket){
    $board[$square] = $player;
    $square += $direction;
  }
}

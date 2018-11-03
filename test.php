<?php
require_once('othello.php');

assert(count(ALL_SQUARES) == 64);
assert(is_valid(01) == false);
assert(is_valid(11) == true);
assert(is_valid(88) == true);
assert(is_valid(89) == false);
assert(legal_moves(TYPE_BLACK, initial_board()) == [34,43,56,65]);

# Run
```bash
php game.php
```

# Preface
- PAIP https://github.com/norvig/paip-lisp/blob/master/docs/chapter18.md (PAIP 11-88 theory)
- Python 1 http://dhconnelly.com/paip-python/docs/paip/othello.html (PAIP 11-88 implementation)
- Python 2 https://github.com/marmelab/reversi.py/ (Matrix implementation)

# Convention
The board is a 1 dimension array of 100 integers from 0 to 99, with playable squares from 11 to 88, following the PAIP board convention for Othello:
- 0 for an empty square
- 1 for a black piece
- 2 for a white piece
- 3 for the outer border
Handling single integers instead of XY coordinates (`$board[x][y]`) or objects (`$square->x $square->y`) saves space for efficiency.
To access the first square of the first line, use `board[11]`. For the second square of the first line, use `$board[12]`. Thus, playable squares are in the range 11-88.
Having the outer border simplifies the detection of out-of-board moves.
Also, it makes it easy to compute neighbors, with directions as integers:
- West=-1, East=+1, North=-10, South=+10
- NW=-11, NE=-9, SW=+9, SE=+11
East of `$board[11]` is `$board[11+1]` = `$board[12]`.
This gives us the following representation of the initial board:
`3333333333
3000000003
3000000003
3000000003
3000210003
3000120003
3000000003
3000000003
3000000003
3333333333`
Each integer is converted to an ascii symbol for improved readability. Where '.' is empty, '@' is black, 'o' is white and '?' is border:
`??????????
?........?
?........?
?........?
?...o@...?
?...@o...?
?........?
?........?
?........?
??????????`

# Vocabulary
A "valid" move is a move within the board, between 11 and 88.
A "legal" move for a given player is a move that forms a "bracket" with another piece of this player. E.g. with the line '11 12 @ o o o 17 18', '17' is a legal move for Black (resulting in 3 "flips") and '12' is a legal move for White (resulting in 1 "flip").
A "ply" is a turn taken by one player (see https://en.wikipedia.org/wiki/Ply_(game_theory)).

# Run tests
```bash
php test.php
```

# Todo
- X create and display board
- X make valid moves and flip pieces
- X create a game with player VS player (strategy_ask)
- X create a game with player VS bot (strategy_random)
- display score
- display winner
- port it to online with HTML and PHP session

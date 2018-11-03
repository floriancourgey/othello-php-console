# Run
```bash
php index.php
```

# Convention
`board` is an array containing all current game settings. `board['cells']` is a 2 dimensions array containing strings (black, white or empty).
A cell is accessed via `board[j][i]` where `j` is the row index and `i` the column index.
In the code (for loops, function parameters, URLs..), j will always come before i.

# Board structure
Board is persisted across session via standard PHP session serialization, and contains the following:
{
  id: 'sha1'
  cells: []
  lastTurn: Datetime
  botPlay: ['j'=> 1, 'i'=> 2]
  playerType: 'black|white'
  botType: 'black|white'
}

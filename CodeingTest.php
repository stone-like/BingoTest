<?php


fscanf(STDIN, '%d', $S);


$bingoCard = [];
for ($i = 0; $i < $S; $i++) {
    $dummy = explode(" ", trim(fgets(STDIN)));
    array_push($bingoCard, $dummy); //二重配列とする[[aa,bb],[cc,dd]]みたいな感じ
}



fscanf(STDIN, '%d', $N);



//ここではbingo上に単語があればその地点をoとしている

for ($i = 0; $i < $N; $i++) {
    $str =  trim(fgets(STDIN));

    for ($j = 0; $j < $S; $j++) {
        for ($k = 0; $k < $S; $k++) {
            if ($bingoCard[$j][$k] === $str) {

                $bingoCard[$j][$k] = 'o';
            }
        }
    }
}





function isBingo($bingoCard, $S)
{
    $answer = false;


    for ($col = 0; $col < $S; $col++) {
        $answer = isBingoCol($bingoCard, $col, $S);
        //もしどこか一つでもtrueであれば後続を見ずにbingoの結果はtrue、この枝刈りを行わないと、もし後続でfalseが出た場合結果がおかしくなってしまうので、
        //trueが出た瞬間に、探索を終わらせるとよい
        if ($answer === true) {
            return true;
        }
    }

    for ($row = 0; $row < $S; $row++) {
        $answer = isBingoRow($bingoCard, $row, $S);
        if ($answer === true) {
            return true;
        }
    }

    $answer = isBingoCrossTopLeft($bingoCard, $S);

    if ($answer === true) {
        return true;
    }


    $answer = isBingoCrossTopRight($bingoCard, $S);
    //この段においてはforをつかってもいないので枝刈りはせずに最後のTopRight(一列分)の結果を返すだけ
    return $answer;
}

function isBingoCol($bingoCard, $colNum, $S)
{

    $col = $bingoCard[$colNum];

    for ($i = 0; $i < $S; $i++) {


        if ("o" !== $col[$i]) {

            return false; //選択したColumnのなかに"o"が入っていない場所があればその時点でビンゴではない
        }
    }

    return true;
}
function isBingoRow($bingoCard, $rowNum, $S)
{
    $row = [];
    for ($i = 0; $i < $S; $i++) {
        array_push($row, $bingoCard[$i][$rowNum]); //rowを作っている
    }

    for ($i = 0; $i < $S; $i++) {

        if ("o" !== $row[$i]) {

            return false; //選択したColumnのなかに"o"が入っていない場所があればその時点でビンゴではない
        }
    }

    return true;
}
function isBingoCrossTopLeft($bingoCard, $S)
{
    $crossLine = [];
    for ($i = 0; $i < $S; $i++) {
        array_push($crossLine, $bingoCard[$i][$i]);
    }


    for ($i = 0; $i < $S; $i++) {

        if ($crossLine[$i] !== "o") {


            return false;
        }
    }

    return true;
}
function isBingoCrossTopRight($bingoCard, $S)
{
    $crossLine = [];
    for ($i = 0; $i < $S; $i++) {
        array_push($crossLine, $bingoCard[$i][$S - $i - 1]);
    }



    for ($i = 0; $i < $S; $i++) {

        if ($crossLine[$i] !== "o") {
            return false;
        }
    }

    return true;
}



if (isBingo($bingoCard, $S)) {
    echo "yes";
} else {
    echo "no";
}

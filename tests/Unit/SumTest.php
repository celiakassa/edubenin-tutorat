<?php

function sum($a,$b){
    return $a+$b;
};

describe('sum', function () {
    it('adds two numbers int ', function () {
        $result = sum(1, 2);
        expect($result)->toBe(3);

    });
    it('adds two numbers float ', function () {
        $result = sum(1.1, 2.2);
        expect(round($result,1))->toBe(3.3);

    });
});

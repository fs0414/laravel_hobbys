<?php
interface ReplaceRulesInterface
{
    public function match(string $carry, int $n): bool;
    public function apply(string $carry, int $n): string;
}

class NumberConverter
{
    public function __construct(
        protected array $rules
    ){}

    public function converter(int $n): string
    {
        $carry = "";
        foreach ($this->rules as $rule) {
            if ($rule->match($carry, $n)) {
                $carry = $rule->apply($carry, $n);
            }
        }
        return $carry;
    }
};

class CyclicNumberRule implements ReplaceRulesInterface
{
    public function __construct(
        protected int $base,
        protected string $replacement
    ){}

    public function match(string $_carry, int $n): bool
    {
        return $n % $this->base === 0;
    }

    public function apply(string $carry, int $n): string
    {
        return $carry . $this->replacement;
    }
}

class PassThroughRule implements ReplaceRulesInterface
{

    public function match(string $carry, int $n): bool
    {
        return $carry == "";
    }

    public function apply(string $carry, int $n): string
    {
        return (string)$n;
    } 
};

$fizzBuzz = new NumberConverter([
    new CyclicNumberRule(3, "Fizz"),
    new CyclicNumberRule(5, "Buzz"),
    new PassThroughRule()
]);

echo $fizzBuzz->converter(1), "\n";
echo $fizzBuzz->converter(3), "\n";
echo $fizzBuzz->converter(5), "\n";
echo $fizzBuzz->converter(3), "\n";
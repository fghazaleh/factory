<?php

declare(strict_types=1);

namespace FG\Bundle\FactoryBundle\Support\Strings;

final class Str
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function make(string $value): Str
    {
        return new static($value);
    }

    /**
     * Convert a value to camel case.
     *
     * @return Str
     */
    public function camel(): Str
    {
        return static::make(
            lcfirst($this->studly()->value())
        );
    }

    /**
     * Convert a value to studly caps case.
     *
     * @return Str
     */
    public function studly(): Str
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $this->value));
        return static::make(
            str_replace(' ', '', $value)
        );
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value();
    }
}
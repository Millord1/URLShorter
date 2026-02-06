<?php

namespace App\Services;

class CodeGenerator
{
    private const CHARSET = '4N7p3Z9mY1wL5kX8rQj2D6vS0tGzH4bAfC9uM1iE8oP7yR6nK5sT3aJ2dQ0gB';

    /**
     * Convert an ID into Base62
     */
    public function encode(int $id): string
    {
        $code = '';
        $base = strlen(self::CHARSET);

        if ($id === 0) return self::CHARSET[0];

        while ($id > 0) {
            $code = self::CHARSET[$id % $base] . $code;
            $id = (int)($id / $base);
        }

        return $code;
    }
}
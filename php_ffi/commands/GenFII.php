<?php namespace app\commands;
use FFI;
use app\commands\double;
interface iGenFII {}
interface iGenFII_ptr {}
class GenFII {
    const SOFILE = '/home/keygenqt/Documents/Home/skill-ffi/php-ffi/../c_lib/build/libc_library.so';
    const TYPES_DEF = '';
    const HEADER_DEF = self::TYPES_DEF . 'int getRandom(int from, int to);
char *generateUUID();
';
    private FFI $ffi;
    private static FFI $staticFFI;
    private array $__literalStrings = [];
    const __x86_64__ = 1;
    const __LP64__ = 1;
    const __GNUC_VA_LIST = 1;
    const __GNUC__ = 4;
    const __GNUC_MINOR__ = 2;
    const __STDC__ = 1;
    public function __construct(?string $pathToSoFile = self::SOFILE) {
        $this->ffi = FFI::cdef(self::HEADER_DEF, $pathToSoFile);
    }

    public static function cast(iGenFII $from, string $to): iGenFII {
        if (!is_a($to, iGenFII::class)) {
            throw new \LogicException("Cannot cast to a non-wrapper type");
        }
        return new $to(self::$staticFFI->cast($to::getType(), $from->getData()));
    }

    public static function makeArray(string $class, int|array $elements): iGenFII {
        $type = $class::getType();
        if (substr($type, -1) !== "*") {
            throw new \LogicException("Attempting to make a non-pointer element into an array");
        }
        if (is_int($elements)) {
            $cdata = self::$staticFFI->new(substr($type, 0, -1) . "[$elements]");
        } else {
            $cdata = self::$staticFFI->new(substr($type, 0, -1) . "[" . count($elements) . "]");
            foreach ($elements as $key => $raw) {
                $cdata[$key] = \is_scalar($raw) ? \is_int($raw) && $type === "char*" ? \chr($raw) : $raw : $raw->getData();
            }
        }
        return new $class($cdata);
    }

    public static function sizeof($classOrObject): int {
        if (is_object($classOrObject) && $classOrObject instanceof iGenFII) {
            return self::$staticFFI->sizeof($classOrObject->getData());
        } elseif (is_a($classOrObject, iGenFII::class)) {
            return self::$staticFFI->sizeof(self::$staticFFI->type($classOrObject::getType()));
        } else {
            throw new \LogicException("Unknown class/object passed to sizeof()");
        }
    }

    public function getFFI(): FFI {
        return $this->ffi;
    }


    public function __get(string $name) {
        switch($name) {
            default: return $this->ffi->$name;
        }
    }
    public function __set(string $name, $value) {
        switch($name) {
            default: return $this->ffi->$name;
        }
    }
    public function __allocCachedString(string $str): FFI\CData {
        return $this->__literalStrings[$str] ??= string_::ownedZero($str)->getData();
    }
    public function getRandom(int $from, int $to): int {
        $result = $this->ffi->getRandom($from, $to);
        return $result;
    }
    public function generateUUID(): ?string_ {
        $result = $this->ffi->generateUUID();
        return $result === null ? null : new string_($result);
    }
}
(function() { self::$staticFFI = \FFI::cdef(GenFII::TYPES_DEF); })->bindTo(null, GenFII::class)();

class string_ implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(string_ $other): bool { return $this->data == $other->data; }
    public function addr(): string_ptr { return new string_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): int { return \ord($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): int { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = \chr($value); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return int[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while ("\0" !== $cur = $this->data[$i++]) { $ret[] = \ord($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = \ord($this->data[$i]); } } return $ret; }
    public function toString(?int $length = null): string { return $length === null ? FFI::string($this->data) : FFI::string($this->data, $length); }
    public static function persistent(string $string): self { $str = new self(FFI::new("char[" . \strlen($string) . "]", false)); FFI::memcpy($str->data, $string, \strlen($string)); return $str; }
    public static function owned(string $string): self { $str = new self(FFI::new("char[" . \strlen($string) . "]", true)); FFI::memcpy($str->data, $string, \strlen($string)); return $str; }
    public static function persistentZero(string $string): self { return self::persistent("$string\0"); }
    public static function ownedZero(string $string): self { return self::owned("$string\0"); }
    public function set(int | void_ptr | string_ $value): void {
        if (\is_scalar($value)) {
            $this->data[0] = \chr($value);
        } else {
            FFI::addr($this->data)[0] = $value->getData();
        }
    }
    public static function getType(): string { return 'char*'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class string_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(string_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): string_ptr_ptr { return new string_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): string_ { return new string_($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): string_ { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return string_[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new string_($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new string_($this->data[$i]); } } return $ret; }
    public function set(void_ptr | string_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'char**'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class string_ptr_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(string_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): string_ptr_ptr_ptr { return new string_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): string_ptr { return new string_ptr($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): string_ptr { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return string_ptr[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new string_ptr($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new string_ptr($this->data[$i]); } } return $ret; }
    public function set(void_ptr | string_ptr_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'char***'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class string_ptr_ptr_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(string_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): string_ptr_ptr_ptr_ptr { return new string_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): string_ptr_ptr { return new string_ptr_ptr($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): string_ptr_ptr { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return string_ptr_ptr[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new string_ptr_ptr($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new string_ptr_ptr($this->data[$i]); } } return $ret; }
    public function set(void_ptr | string_ptr_ptr_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'char***'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class void_ptr implements iGenFII, iGenFII_ptr {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(void_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): void_ptr_ptr { return new void_ptr_ptr(FFI::addr($this->data)); }
    public function set(iGenFII_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'void*'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class void_ptr_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(void_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): void_ptr_ptr_ptr { return new void_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): void_ptr { return new void_ptr($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): void_ptr { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return void_ptr[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new void_ptr($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new void_ptr($this->data[$i]); } } return $ret; }
    public function set(void_ptr | void_ptr_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'void**'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class void_ptr_ptr_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(void_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): void_ptr_ptr_ptr_ptr { return new void_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): void_ptr_ptr { return new void_ptr_ptr($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): void_ptr_ptr { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return void_ptr_ptr[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new void_ptr_ptr($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new void_ptr_ptr($this->data[$i]); } } return $ret; }
    public function set(void_ptr | void_ptr_ptr_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'void***'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class void_ptr_ptr_ptr_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(void_ptr_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): void_ptr_ptr_ptr_ptr_ptr { return new void_ptr_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): void_ptr_ptr_ptr { return new void_ptr_ptr_ptr($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): void_ptr_ptr_ptr { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return void_ptr_ptr_ptr[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new void_ptr_ptr_ptr($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new void_ptr_ptr_ptr($this->data[$i]); } } return $ret; }
    public function set(void_ptr | void_ptr_ptr_ptr_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'void****'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class int_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(int_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): int_ptr_ptr { return new int_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): int { return $this->data[$n]; }
    #[\ReturnTypeWillChange] public function offsetGet($offset): int { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value; }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return int[] */ public function toArray(int $length): array { $ret = []; for ($i = 0; $i < $length; ++$i) { $ret[] = ($this->data[$i]); } return $ret; }
    public function set(int | void_ptr | int_ptr $value): void {
        if (\is_scalar($value)) {
            $this->data[0] = $value;
        } else {
            FFI::addr($this->data)[0] = $value->getData();
        }
    }
    public static function getType(): string { return 'int*'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class int_ptr_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(int_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): int_ptr_ptr_ptr { return new int_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): int_ptr { return new int_ptr($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): int_ptr { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return int_ptr[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new int_ptr($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new int_ptr($this->data[$i]); } } return $ret; }
    public function set(void_ptr | int_ptr_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'int**'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class int_ptr_ptr_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(int_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): int_ptr_ptr_ptr_ptr { return new int_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): int_ptr_ptr { return new int_ptr_ptr($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): int_ptr_ptr { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return int_ptr_ptr[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new int_ptr_ptr($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new int_ptr_ptr($this->data[$i]); } } return $ret; }
    public function set(void_ptr | int_ptr_ptr_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'int***'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
class int_ptr_ptr_ptr_ptr implements iGenFII, iGenFII_ptr, \ArrayAccess {
    private FFI\CData $data;
    public function __construct(FFI\CData $data) { $this->data = $data; }
    public static function castFrom(iGenFII $data): self { return GenFII::cast($data, self::class); }
    public function getData(): FFI\CData { return $this->data; }
    public function equals(int_ptr_ptr_ptr_ptr $other): bool { return $this->data == $other->data; }
    public function addr(): int_ptr_ptr_ptr_ptr_ptr { return new int_ptr_ptr_ptr_ptr_ptr(FFI::addr($this->data)); }
    public function deref(int $n = 0): int_ptr_ptr_ptr { return new int_ptr_ptr_ptr($this->data[$n]); }
    #[\ReturnTypeWillChange] public function offsetGet($offset): int_ptr_ptr_ptr { return $this->deref($offset); }
    #[\ReturnTypeWillChange] public function offsetExists($offset): bool { return !FFI::isNull($this->data); }
    #[\ReturnTypeWillChange] public function offsetUnset($offset): void { throw new \Error("Cannot unset C structures"); }
    #[\ReturnTypeWillChange] public function offsetSet($offset, $value): void { $this->data[$offset] = $value->getData(); }
    public static function array(int $size = 1): self { return GenFII::makeArray(self::class, $size); }
    /** @return int_ptr_ptr_ptr[] */ public function toArray(?int $length = null): array { $ret = []; if ($length === null) { $i = 0; while (null !== $cur = $this->data[$i++]) { $ret[] = new int_ptr_ptr_ptr($cur); } } else { for ($i = 0; $i < $length; ++$i) { $ret[] = new int_ptr_ptr_ptr($this->data[$i]); } } return $ret; }
    public function set(void_ptr | int_ptr_ptr_ptr_ptr $value): void {
        FFI::addr($this->data)[0] = $value->getData();
    }
    public static function getType(): string { return 'int****'; }
    public static function size(): int { return GenFII::sizeof(self::class); }
    public function getDefinition(): string { return static::getType(); }
}
FFI (Foreign function interface)
===================

A simple example of creating your [library](c_lib) on C and using it in different languages through tools proposed by the language.
Everything was launched on Ubuntu 22.04.

#### library.h

```c
// Generate random int
int getRandom(int from, int to);

// Generate UUID string
char *generateUUID();
```

The rating of the complexity of use 1-5. In My Humble Opinion. Less is better.

#### Languages

* (4) [Java](java_ffi) ([jextract](https://github.com/openjdk/jextract))
* (1) [Dart](dart_ffi) ([ffigen](https://pub.dev/packages/ffigen))
* (1) [Python](python_ffi) ([ctypesgen](https://github.com/ctypesgen/ctypesgen))
* (1) [PHP](php_ffi) ([FFIMe](https://github.com/ircmaxell/FFIMe))
* (1) [JS](js_fii) ([ffi-napi](https://www.npmjs.com/package/ffi-napi))
* (1) [Rust](rust_ffi) ([bindgen](https://github.com/rust-lang/rust-bindgen))

#### Output

```bash
| Run c methods
| -----------------------------------------------------
| getRandom(0, 9): 5
| generateUUID():  b3066d6d-6ed3-4896-30b8-b68742c06c6c
| -----------------------------------------------------
```

#### Little bonus

An example of the assembly of the library on Kotlin Multiplatform ([km_lib](km_lib))

### License

```
Copyright 2023 Vitaliy Zarubin

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```

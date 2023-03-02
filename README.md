FFI (Foreign function interface)
===================

Launch methods from the C library in different languages on Linux

#### library.h

```c
// Generate random int
int getRandom(int from, int to);

// Generate UUID string
char *generateUUID();
```

Difficulty rating: 1-5. Less is better.

#### Languages

* ✔ (4) Java/Kotlin (Generation of what is what is not)
* ✔ (1) Dart (It's just top)
* ✔ (1) Python (ctypesgen is awesome)
* ✔ (1) PHP (ircmaxell/ffime is awesome)
* ✔ (1) JS (I did not find the generator, but ffi-napi did well without it)
* ☹ (5) Swift (Everything is easier with xcode)
* ✔ (1) Rust (bindgen the best)
* ? ⇦

#### Output

```bash
| Run c methods
| -----------------------------------------------------
| getRandom(0, 9): 5
| generateUUID():  b3066d6d-6ed3-4896-30b8-b68742c06c6c
| -----------------------------------------------------
```

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

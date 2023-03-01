FFI (Foreign function interface)
===================

Launch methods from the C library in different languages

#### library.h

```c
// Generate random int
int getRandom(int from, int to);

// Generate UUID string
char *generateUUID();
```

#### Languages

* Java ✔️
* Dart ✔️
* Python ✔️
* PHP ✔️
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

#!/bin/bash

## download from
## https://jdk.java.net/jextract/
./jextract/bin/jextract --source -t com.keygenqt.c_lib ../c_lib/library.h

rm -rf java_ffi/src/main/java/com/keygenqt/c_lib

mv com/keygenqt/c_lib java_ffi/src/main/java/com/keygenqt/c_lib

rm -rf com

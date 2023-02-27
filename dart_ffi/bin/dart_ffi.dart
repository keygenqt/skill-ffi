import 'dart:ffi' as ffi;
import 'dart:io';

import "package:ffi/ffi.dart";
import 'package:path/path.dart' as path;

import 'generated_fii.dart';

void main(List<String> arguments) {
  var libraryPath = path.join(
      Directory.current.path, '..', 'c_lib', 'build', 'libc_library.so');

  final dylib = ffi.DynamicLibrary.open(libraryPath);

  final lib = NativeLibrary(dylib);

  final random = lib.getRandom(0, 9);
  final uuid = lib.generateUUID().cast<Utf8>().toDartString();

  print('\n| Run c methods');
  print('| -----------------------------------------------------');
  print('| getRandom(0, 9): $random');
  print('| generateUUID():  $uuid');
  print('| -----------------------------------------------------');
}

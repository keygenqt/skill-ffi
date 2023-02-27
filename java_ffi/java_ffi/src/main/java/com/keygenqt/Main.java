package com.keygenqt;

import java.io.FileNotFoundException;
import java.io.PrintStream;
import java.nio.file.Paths;

import static com.keygenqt.c_lib.library_h.generateUUID;
import static com.keygenqt.c_lib.library_h.getRandom;

public class Main {

    static {
        // include library
        String workDir = Paths.get("").toAbsolutePath().toString();
        System.load(workDir + "/../../c_lib/build/libc_library.so");
    }

    public static void main(String[] args) throws FileNotFoundException {
        // disable warning Linker
        System.setErr(new PrintStream("/dev/null"));

        int random = getRandom(0, 9);
        String uuid = generateUUID().getUtf8String(0);

        // run c methods
        System.out.println("\n| Run c methods");
        System.out.println("| -----------------------------------------------------");
        System.out.println("| getRandom(0, 9): " + random);
        System.out.println("| generateUUID():  " + uuid);
        System.out.println("| -----------------------------------------------------");
    }
}
// Generated by jextract

package com.keygenqt.c_lib;

import java.lang.invoke.MethodHandle;
import java.lang.invoke.VarHandle;
import java.nio.ByteOrder;
import java.lang.foreign.*;
import static java.lang.foreign.ValueLayout.*;
public class library_h  {

    /* package-private */ library_h() {}
    public static OfByte C_CHAR = Constants$root.C_CHAR$LAYOUT;
    public static OfShort C_SHORT = Constants$root.C_SHORT$LAYOUT;
    public static OfInt C_INT = Constants$root.C_INT$LAYOUT;
    public static OfLong C_LONG = Constants$root.C_LONG_LONG$LAYOUT;
    public static OfLong C_LONG_LONG = Constants$root.C_LONG_LONG$LAYOUT;
    public static OfFloat C_FLOAT = Constants$root.C_FLOAT$LAYOUT;
    public static OfDouble C_DOUBLE = Constants$root.C_DOUBLE$LAYOUT;
    public static OfAddress C_POINTER = Constants$root.C_POINTER$LAYOUT;
    public static MethodHandle getRandom$MH() {
        return RuntimeHelper.requireNonNull(constants$0.getRandom$MH,"getRandom");
    }
    public static int getRandom ( int from,  int to) {
        var mh$ = getRandom$MH();
        try {
            return (int)mh$.invokeExact(from, to);
        } catch (Throwable ex$) {
            throw new AssertionError("should not reach here", ex$);
        }
    }
    public static MethodHandle generateUUID$MH() {
        return RuntimeHelper.requireNonNull(constants$0.generateUUID$MH,"generateUUID");
    }
    public static MemoryAddress generateUUID (Object... x0) {
        var mh$ = generateUUID$MH();
        try {
            return (java.lang.foreign.MemoryAddress)mh$.invokeExact(x0);
        } catch (Throwable ex$) {
            throw new AssertionError("should not reach here", ex$);
        }
    }
}


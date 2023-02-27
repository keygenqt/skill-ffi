CMAKE_MINIMUM_REQUIRED (VERSION 3.0.2)
project(c_library VERSION 0.0.1)

add_library(c_library SHARED library.c)

set_target_properties(c_library PROPERTIES
    PUBLIC_HEADER library.h
    VERSION ${PROJECT_VERSION}
    SOVERSION 1
    OUTPUT_NAME "c_library"
    XCODE_ATTRIBUTE_CODE_SIGN_IDENTITY "Hex_Identity_ID_Goes_Here"
)


## Ubuntu 22.04
export LIBCLANG_PATH=/usr/lib/llvm-14/lib/
## export my lib
export LD_LIBRARY_PATH=$LD_LIBRARY_PATH:"$PWD/../c_lib/build"
## run build
cargo run
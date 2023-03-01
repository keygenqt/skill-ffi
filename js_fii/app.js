const ffi = require('ffi-napi');

const lib = ffi.Library('../c_lib/build/libc_library.so', {
    'getRandom': ['int', ['int', 'int']],
    'generateUUID': ['string', []],
});

console.log(`
| Run c methods
| -----------------------------------------------------
| getRandom(0, 9): ${lib.getRandom(0, 9)}
| generateUUID():  ${lib.generateUUID()}
| -----------------------------------------------------
`);
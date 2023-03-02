#![allow(non_upper_case_globals)]
#![allow(non_camel_case_types)]
#![allow(non_snake_case)]

include!(concat!(env!("OUT_DIR"), "/bindings.rs"));

use std::ffi::CStr;

fn main() {

    let c_ran = unsafe { getRandom(0, 9) };

    let c_str = unsafe { CStr::from_ptr(generateUUID()) };
    let str_slice: &str = c_str.to_str().unwrap();
    let str_buf: String = str_slice.to_owned();

println!("
| Run c methods
| -----------------------------------------------------
| getRandom(0, 9): {}
| generateUUID():  {}
| -----------------------------------------------------
", c_ran, str_buf);

}

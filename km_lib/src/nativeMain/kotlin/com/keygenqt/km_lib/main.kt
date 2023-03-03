package com.keygenqt.km_lib

import kotlinx.uuid.UUID
import kotlinx.uuid.generateUUID
import kotlin.random.Random

// kotlin
fun getRandom(from: Int, to: Int): Int {
    return (from..to).random()
}

// https://github.com/hfhbd/kotlinx-uuid
fun generateUUID(): String {
    return UUID.generateUUID(Random.Default).toString()
}
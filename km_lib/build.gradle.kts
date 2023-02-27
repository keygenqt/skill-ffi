plugins {
    kotlin("multiplatform") version "1.8.10"
}

group = "com.keygenqt"
version = "1.0-SNAPSHOT"

repositories {
    mavenCentral()
}

kotlin {
    val hostOs = System.getProperty("os.name")
    val isMingwX64 = hostOs.startsWith("Windows")
    when {
        hostOs == "Mac OS X" -> macosX64("native") {
            binaries {
                sharedLib {
                    baseName = "native" // on Linux and macOS
                }
            }
        }

        hostOs == "Linux" -> linuxX64("native") {
            binaries {
                sharedLib {
                    baseName = "native" // on Linux and macOS
                }
            }
        }

        isMingwX64 -> mingwX64("native") {
            binaries {
                sharedLib {
                    baseName = "libnative" // on Windows
                }
            }
        }

        else -> throw GradleException("Host OS is not supported in Kotlin/Native.")
    }

    sourceSets {
        val nativeMain by getting {
            dependencies {
                implementation("app.softwork:kotlinx-uuid-core:0.0.16")
            }
        }
    }
}

package com.xiecy.webshell;

import ch.ethz.ssh2.Connection;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

import java.io.IOException;

@SpringBootApplication
public class WebshellApplication {

	public static void main(String[] args) throws IOException {

		SpringApplication.run(WebshellApplication.class, args);
	}
}

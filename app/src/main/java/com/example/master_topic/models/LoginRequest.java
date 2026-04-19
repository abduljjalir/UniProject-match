package com.example.master_topic.models;

public class LoginRequest {
    private String identifiant;
    private String password;
    private String role;

    public LoginRequest(String identifiant, String password, String role) {
        this.identifiant = identifiant;
        this.password = password;
        this.role = role;
    }
}
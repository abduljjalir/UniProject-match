package com.example.master_topic.models;

public class LoginResponse {
    private String token;
    private String role;
    private String message;

    public String getToken() { return token; }
    public String getRole() { return role; }
    public String getMessage() { return message; }
}
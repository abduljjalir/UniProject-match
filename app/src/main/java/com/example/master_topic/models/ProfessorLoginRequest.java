package com.example.master_topic.models;

public class ProfessorLoginRequest {
    private String professor_id;
    private String password;

    public ProfessorLoginRequest(String professor_id, String password) {
        this.professor_id = professor_id;
        this.password = password;
    }
}
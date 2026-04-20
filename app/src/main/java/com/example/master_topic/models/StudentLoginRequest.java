package com.example.master_topic.models;

public class StudentLoginRequest {
    private String student_id;
    private String password;

    public StudentLoginRequest(String student_id, String password) {
        this.student_id = student_id;
        this.password = password;
    }
}
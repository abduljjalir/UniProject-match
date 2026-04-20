package com.example.master_topic.models;

public class Appeal {
    private int id;
    private int studentId;
    private String reason;
    private String status;
    private String date;

    // Getters
    public int getId() { return id; }
    public int getStudentId() { return studentId; }
    public String getReason() { return reason; }
    public String getStatus() { return status; }
    public String getDate() { return date; }
}
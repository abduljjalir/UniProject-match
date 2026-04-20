package com.example.master_topic.models;

import java.util.List;

public class Student {
    private int id;
    private String name;
    private String email;
    private double gpa;
    private List<String> skills;
    private String status;
    private int assignedProjectId;

    // Getters
    public int getId() { return id; }
    public String getName() { return name; }
    public String getEmail() { return email; }
    public double getGpa() { return gpa; }
    public List<String> getSkills() { return skills; }
    public String getStatus() { return status; }
    public int getAssignedProjectId() { return assignedProjectId; }
}
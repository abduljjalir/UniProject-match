package com.example.master_topic.models;

import java.util.List;

public class Project {
    private int id;
    private String title;
    private String description;
    private List<String> skills;
    private double minGpa;
    private String difficulty;
    private int maxStudents;
    private int enrolled;
    private String field;

    // Getters
    public int getId() { return id; }
    public String getTitle() { return title; }
    public String getDescription() { return description; }
    public List<String> getSkills() { return skills; }
    public double getMinGpa() { return minGpa; }
    public String getDifficulty() { return difficulty; }
    public int getMaxStudents() { return maxStudents; }
    public int getEnrolled() { return enrolled; }
    public String getField() { return field; }
}
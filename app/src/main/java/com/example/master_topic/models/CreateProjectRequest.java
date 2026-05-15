package com.example.master_topic.models;

import java.util.List;

public class CreateProjectRequest {
    private String title;
    private String description;
    private int max_students;
    private int required_points;
    private List<String> skills;

    public CreateProjectRequest(String title, String description,
                                int max_students, int required_points,
                                List<String> skills) {
        this.title = title;
        this.description = description;
        this.max_students = max_students;
        this.required_points = required_points;
        this.skills = skills;
    }
}
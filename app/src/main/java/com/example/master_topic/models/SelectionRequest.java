package com.example.master_topic.models;

public class SelectionRequest {
    private int project_id;
    private int priority;

    public SelectionRequest(int project_id, int priority) {
        this.project_id = project_id;
        this.priority = priority;
    }
}
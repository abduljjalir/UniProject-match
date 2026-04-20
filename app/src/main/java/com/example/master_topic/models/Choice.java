package com.example.master_topic.models;

public class Choice {
    private int projectId;
    private int priority;

    public Choice(int projectId, int priority) {
        this.projectId = projectId;
        this.priority = priority;
    }

    public int getProjectId() { return projectId; }
    public int getPriority() { return priority; }
}
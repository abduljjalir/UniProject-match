package com.example.master_topic.api;

import com.example.master_topic.models.LoginRequest;
import com.example.master_topic.models.LoginResponse;
import com.example.master_topic.models.ProfessorLoginRequest;
import com.example.master_topic.models.Project;
import com.example.master_topic.models.Choice;
import com.example.master_topic.models.Appeal;
import com.example.master_topic.models.StudentLoginRequest;

import java.util.List;
import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;

public interface ApiService {

    // ── Auth ──────────────────────────────────────
    @POST("auth/student/login")
    Call<LoginResponse> studentLogin(@Body StudentLoginRequest request);

    @POST("auth/professor/login")
    Call<LoginResponse> professorLogin(@Body ProfessorLoginRequest request);
    @POST("auth/logout")
    Call<Void> logout();

    // ── Projets ───────────────────────────────────
    @GET("projects")
    Call<List<Project>> getProjects();

    @GET("projects/{id}")
    Call<Project> getProjectDetails(@Path("id") int id);

    // ── Sélections (étudiant) ─────────────────────
    @POST("selections")
    Call<Void> submitSelections(@Body List<Choice> choices);

    @GET("selections/me")
    Call<List<Project>> getMySelections();

    // ── Résultats ─────────────────────────────────
    @GET("results/me")
    Call<Project> getMyResult();

    @GET("professors/me/students")
    Call<List<Object>> getMyStudents();

    // ── Allocation (admin) ────────────────────────
    @POST("allocation/run")
    Call<Void> runAlgorithm();

    @GET("allocation/status")
    Call<Object> getAllocationStatus();
}
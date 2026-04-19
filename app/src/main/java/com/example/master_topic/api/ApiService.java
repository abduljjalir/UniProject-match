package com.example.master_topic.api;

import com.example.master_topic.models.LoginRequest;
import com.example.master_topic.models.LoginResponse;
import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;

public interface ApiService {

    @POST("auth/login")
    Call<LoginResponse> login(@Body LoginRequest request);

}
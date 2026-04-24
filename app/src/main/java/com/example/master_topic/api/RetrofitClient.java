package com.example.master_topic.api;

import android.content.Context;
import android.content.SharedPreferences;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class RetrofitClient {

    private static final String BASE_URL = "https://votrebackend.com/api/";
    private static Retrofit instance = null;

    public static ApiService getApiService(Context context) {
        if (instance == null) {

            // 1. Interceptor pour les logs
            HttpLoggingInterceptor logging = new HttpLoggingInterceptor();
            logging.setLevel(HttpLoggingInterceptor.Level.BODY);

            // 2. Interceptor pour le token
            OkHttpClient client = new OkHttpClient.Builder()
                    .addInterceptor(logging)
                    .addInterceptor(chain -> {

                        // Récupérer le token sauvegardé
                        SharedPreferences prefs = context
                                .getSharedPreferences("UniProject", Context.MODE_PRIVATE);
                        String token = prefs.getString("token", "");

                        // Ajouter le token dans l'en-tête
                        Request request = chain.request().newBuilder()
                                .addHeader("Authorization", "Bearer " + token)
                                .addHeader("Accept", "application/json")
                                .build();

                        return chain.proceed(request);
                    })
                    .build();

            instance = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .client(client)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build();
        }
        return instance.create(ApiService.class);
    }
}
package com.example.master_topic;

import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import android.content.SharedPreferences;
import com.example.master_topic.api.ApiService;
import com.example.master_topic.api.RetrofitClient;
import com.example.master_topic.models.LoginResponse;
import com.example.master_topic.models.ProfessorLoginRequest;
import com.example.master_topic.models.StudentLoginRequest;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class MainActivity extends AppCompatActivity {

    Button btnStudent, btnProfessor, btnLogin;
    EditText etStudentId, etPassword;
    TextView tvForgotPassword;

    boolean isStudentMode = true;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        btnStudent       = findViewById(R.id.btnStudent);
        btnProfessor     = findViewById(R.id.btnProfessor);
        btnLogin         = findViewById(R.id.btnLogin);
        etStudentId      = findViewById(R.id.etStudentId);
        etPassword       = findViewById(R.id.etPassword);
        tvForgotPassword = findViewById(R.id.tvForgotPassword);

        // Toggle Student
        btnStudent.setOnClickListener(v -> switchMode(true));

        // Toggle Professor
        btnProfessor.setOnClickListener(v -> switchMode(false));

        // Login
        btnLogin.setOnClickListener(v -> handleLogin());

        // Forgot password
        tvForgotPassword.setOnClickListener(v ->
                Toast.makeText(this, "Réinitialisation envoyée", Toast.LENGTH_SHORT).show()
        );
    }

    void switchMode(boolean studentMode) {
        isStudentMode = studentMode;

        if (studentMode) {
            btnStudent.setBackgroundResource(R.drawable.bg_toggle_selected);
            btnStudent.setTextColor(0xFFFFFFFF);
            btnProfessor.setBackgroundResource(android.R.color.transparent);
            btnProfessor.setTextColor(0xFF8A96A3);
            etStudentId.setHint("Student ID");
        } else {
            btnProfessor.setBackgroundResource(R.drawable.bg_toggle_selected);
            btnProfessor.setTextColor(0xFFFFFFFF);
            btnStudent.setBackgroundResource(android.R.color.transparent);
            btnStudent.setTextColor(0xFF8A96A3);
            etStudentId.setHint("Professor ID");
        }

        etStudentId.setText("");
        etPassword.setText("");
    }

    void handleLogin() {
        String id  = etStudentId.getText().toString().trim();
        String pwd = etPassword.getText().toString().trim();

        if (id.isEmpty()) {
            etStudentId.setError("Champ requis");
            return;
        }
        if (pwd.isEmpty()) {
            etPassword.setError("Champ requis");
            return;
        }

        ApiService api = RetrofitClient.getApiService();


        // Créer la bonne requête selon le mode
        Call<LoginResponse> call;

        if (isStudentMode) {
            StudentLoginRequest request = new StudentLoginRequest(id, pwd);
            call = api.studentLogin(request);
        } else {
            ProfessorLoginRequest request = new ProfessorLoginRequest(id, pwd);
            call = api.professorLogin(request);
        }

        call.enqueue(new Callback<LoginResponse>() {
            @Override
            public void onResponse(Call<LoginResponse> call, Response<LoginResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    String token = response.body().getToken();
                    String role  = response.body().getRole();
                    saveSession(token, role);
                    naviguerSelonRole(role);
                } else {
                    Toast.makeText(MainActivity.this,
                            "Identifiant ou mot de passe incorrect",
                            Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<LoginResponse> call, Throwable t) {
                Toast.makeText(MainActivity.this,
                        "Erreur réseau",
                        Toast.LENGTH_SHORT).show();
            }
        });
    }
    void saveSession(String token, String role) {
        SharedPreferences prefs = getSharedPreferences("UniProject", MODE_PRIVATE);
        prefs.edit()
                .putString("token", token)
                .putString("role", role)
                .apply();
    }

    void naviguerSelonRole(String role) {
        switch (role) {
            case "etudiant":
                // TODO: remplacer par StudentDashboardActivity
                Toast.makeText(this, "Bienvenue étudiant !", Toast.LENGTH_SHORT).show();
                break;
            case "professeur":
                // TODO: remplacer par ProfessorDashboardActivity
                Toast.makeText(this, "Bienvenue professeur !", Toast.LENGTH_SHORT).show();
                break;
            case "admin":
                // TODO: remplacer par AdminDashboardActivity
                Toast.makeText(this, "Bienvenue admin !", Toast.LENGTH_SHORT).show();
                break;
        }
    }
}
package com.example.master_topic;

import android.os.Bundle;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

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

        String role = isStudentMode ? "Étudiant" : "Professeur";
        Toast.makeText(this, "Connecté : " + role + " — " + id, Toast.LENGTH_SHORT).show();

        // TODO: Naviguer vers le prochain écran
        // Intent intent = new Intent(this, DashboardActivity.class);
        // startActivity(intent);
    }
}
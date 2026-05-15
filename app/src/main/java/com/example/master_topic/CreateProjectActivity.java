package com.example.master_topic; // ⚠️ Vérifie ton package

import android.app.AlertDialog;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.example.master_topic.api.ApiService;
import com.example.master_topic.api.RetrofitClient;
import com.example.master_topic.models.CreateProjectRequest;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class CreateProjectActivity extends AppCompatActivity {

    LinearLayout skillsContainer;
    Button btnAddSkill, btnCancel, btnCreateProject;
    EditText etTitle, etDescription, etMaxStudents, etRequiredPoints;
    TextView btnBack;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_create_project);

        // Init vues
        skillsContainer   = findViewById(R.id.skillsContainer);
        btnAddSkill       = findViewById(R.id.btnAddSkill);
        btnCancel         = findViewById(R.id.btnCancel);
        btnCreateProject  = findViewById(R.id.btnCreateProject);
        etTitle           = findViewById(R.id.etTitle);
        etDescription     = findViewById(R.id.etDescription);
        etMaxStudents     = findViewById(R.id.etMaxStudents);
        etRequiredPoints  = findViewById(R.id.etRequiredPoints);
        btnBack           = findViewById(R.id.btnBack);

        // Retour
        btnBack.setOnClickListener(v -> finish());

        // Annuler
        btnCancel.setOnClickListener(v -> finish());

        // Ajouter un skill → ouvre le dialog
        btnAddSkill.setOnClickListener(v -> showAddSkillDialog());

        // Créer le projet
        btnCreateProject.setOnClickListener(v -> handleCreateProject());
    }

    // ===== DIALOG AJOUT SKILL =====
    private void showAddSkillDialog() {
        // Crée une vue pour le dialog
        View dialogView = LayoutInflater.from(this).inflate(R.layout.dialog_add_skill, null);

        EditText etSkillName   = dialogView.findViewById(R.id.etSkillName);
        EditText etSkillPoints = dialogView.findViewById(R.id.etSkillPoints);

        new AlertDialog.Builder(this)
                .setTitle("Add Skill")
                .setView(dialogView)
                .setPositiveButton("Add", (dialog, which) -> {
                    String name   = etSkillName.getText().toString().trim();
                    String points = etSkillPoints.getText().toString().trim();

                    if (name.isEmpty() || points.isEmpty()) {
                        Toast.makeText(this, "Remplis les deux champs", Toast.LENGTH_SHORT).show();
                        return;
                    }
                    addSkillRow(name, points);
                })
                .setNegativeButton("Cancel", null)
                .show();
    }

    // ===== AJOUTE UNE LIGNE SKILL DYNAMIQUEMENT =====
    private void addSkillRow(String skillName, String skillPoints) {
        // Ligne du skill
        LinearLayout row = new LinearLayout(this);
        row.setOrientation(LinearLayout.HORIZONTAL);
        row.setGravity(android.view.Gravity.CENTER_VERTICAL);

        LinearLayout.LayoutParams rowParams = new LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.MATCH_PARENT,
                dpToPx(46)
        );
        row.setLayoutParams(rowParams);
        row.setPadding(dpToPx(14), 0, dpToPx(14), 0);

        // Séparateur en haut si ce n'est pas la première ligne
        if (skillsContainer.getChildCount() > 0) {
            View divider = new View(this);
            LinearLayout.LayoutParams divParams = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT, dpToPx(1)
            );
            divider.setLayoutParams(divParams);
            divider.setBackgroundColor(0xFFEEF3F8);
            skillsContainer.addView(divider);
        }

        // Nom du skill
        TextView tvName = new TextView(this);
        LinearLayout.LayoutParams nameParams = new LinearLayout.LayoutParams(
                0, LinearLayout.LayoutParams.WRAP_CONTENT, 1f
        );
        tvName.setLayoutParams(nameParams);
        tvName.setText(skillName);
        tvName.setTextColor(0xFF1A2B3C);
        tvName.setTextSize(13);
        tvName.setTypeface(null, android.graphics.Typeface.BOLD);

        // Points du skill
        TextView tvPoints = new TextView(this);
        LinearLayout.LayoutParams pointsParams = new LinearLayout.LayoutParams(
                dpToPx(52), LinearLayout.LayoutParams.WRAP_CONTENT
        );
        tvPoints.setLayoutParams(pointsParams);
        tvPoints.setText(skillPoints);
        tvPoints.setTextColor(0xFF2E86DE);
        tvPoints.setTextSize(13);
        tvPoints.setTypeface(null, android.graphics.Typeface.BOLD);
        tvPoints.setGravity(android.view.Gravity.CENTER);
        tvPoints.setBackgroundResource(R.drawable.bg_skill_points);
        tvPoints.setPadding(dpToPx(6), dpToPx(4), dpToPx(6), dpToPx(4));

        row.addView(tvName);
        row.addView(tvPoints);
        skillsContainer.addView(row);
    }

    // ===== CRÉER LE PROJET =====
    private void handleCreateProject() {
        String title  = etTitle.getText().toString().trim();
        String desc   = etDescription.getText().toString().trim();
        String maxStu = etMaxStudents.getText().toString().trim();
        String reqPts = etRequiredPoints.getText().toString().trim();

        // Validation
        if (title.isEmpty()) {
            etTitle.setError("Champ requis");
            return;
        }
        if (desc.isEmpty()) {
            etDescription.setError("Champ requis");
            return;
        }
        if (maxStu.isEmpty()) {
            etMaxStudents.setError("Champ requis");
            return;
        }
        if (reqPts.isEmpty()) {
            etRequiredPoints.setError("Champ requis");
            return;
        }
        if (skillsContainer.getChildCount() == 0) {
            Toast.makeText(this, "Ajoute au moins un skill", Toast.LENGTH_SHORT).show();
            return;
        }

        // Récupérer les skills ajoutés
        List<String> skills = new ArrayList<>();
        for (int i = 0; i < skillsContainer.getChildCount(); i++) {
            View child = skillsContainer.getChildAt(i);
            if (child instanceof LinearLayout) {
                LinearLayout row = (LinearLayout) child;
                if (row.getChildCount() > 0) {
                    TextView tvName = (TextView) row.getChildAt(0);
                    skills.add(tvName.getText().toString());
                }
            }
        }

        // Créer la requête
        CreateProjectRequest request = new CreateProjectRequest(
                title,
                desc,
                Integer.parseInt(maxStu),
                Integer.parseInt(reqPts),
                skills
        );

        // Appel API
        ApiService api = RetrofitClient.getApiService(this);
        api.createProject(request).enqueue(new Callback<Void>() {
            @Override
            public void onResponse(Call<Void> call, Response<Void> response) {
                if (response.isSuccessful()) {
                    Toast.makeText(CreateProjectActivity.this,
                            "Projet créé avec succès !",
                            Toast.LENGTH_SHORT).show();
                    finish();
                } else {
                    Toast.makeText(CreateProjectActivity.this,
                            "Erreur : " + response.code(),
                            Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<Void> call, Throwable t) {
                Toast.makeText(CreateProjectActivity.this,
                        "Erreur réseau",
                        Toast.LENGTH_SHORT).show();
            }
        });
    }

    // Convertir dp en pixels
    private int dpToPx(int dp) {
        return (int) (dp * getResources().getDisplayMetrics().density);
    }
}

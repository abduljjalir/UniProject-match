package com.example.master_topic;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import com.example.master_topic.api.ApiService;
import com.example.master_topic.api.RetrofitClient;
import com.example.master_topic.models.Project;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ProjectDetailActivity extends AppCompatActivity {

    TextView tvProjectTitle, tvProjectDesc, btnBack;
    LinearLayout skillsContainer;
    Button btnSelectProject;
    boolean isSelected = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_project_detail);

        // Init vues
        tvProjectTitle   = findViewById(R.id.tvProjectTitle);
        tvProjectDesc    = findViewById(R.id.tvProjectDesc);
        skillsContainer  = findViewById(R.id.skillsContainer);
        btnSelectProject = findViewById(R.id.btnSelectProject);
        btnBack          = findViewById(R.id.btnBack);

        // Récupérer les données transmises
        int projectId     = getIntent().getIntExtra("projectId", -1);
        String title      = getIntent().getStringExtra("projectTitle");
        String desc       = getIntent().getStringExtra("projectDesc");

        // Afficher titre et description
        if (title != null) tvProjectTitle.setText(title);
        if (desc != null)  tvProjectDesc.setText(desc);

        // Retour
        btnBack.setOnClickListener(v -> finish());

        // Bouton sélection
        btnSelectProject.setOnClickListener(v -> toggleSelection(projectId));

        // Charger les détails depuis l'API
        if (projectId != -1) {
            chargerDetailsProjet(projectId);
        }
    }

    void chargerDetailsProjet(int projectId) {
        ApiService api = RetrofitClient.getApiService(this);

        api.getProjectDetails(projectId).enqueue(new Callback<Project>() {
            @Override
            public void onResponse(Call<Project> call, Response<Project> response) {
                if (response.isSuccessful() && response.body() != null) {
                    Project project = response.body();

                    // Mettre à jour titre et description
                    tvProjectTitle.setText(project.getTitle());
                    tvProjectDesc.setText(project.getDescription());

                    // Afficher les vrais skills
                    afficherSkills(project.getSkills());
                }
            }

            @Override
            public void onFailure(Call<Project> call, Throwable t) {
                Toast.makeText(ProjectDetailActivity.this,
                        "Erreur réseau",
                        Toast.LENGTH_SHORT).show();
            }
        });
    }

    void afficherSkills(java.util.List<String> skills) {
        skillsContainer.removeAllViews();

        if (skills == null || skills.isEmpty()) {
            TextView tv = new TextView(this);
            tv.setText("Aucun skill requis");
            skillsContainer.addView(tv);
            return;
        }

        for (String skill : skills) {
            View item = LayoutInflater.from(this)
                    .inflate(R.layout.item_skill_check, skillsContainer, false);
            TextView tvCheckbox  = item.findViewById(R.id.tvCheckbox);
            TextView tvSkillName = item.findViewById(R.id.tvSkillName);

            tvSkillName.setText(skill);
            tvCheckbox.setText("");
            tvCheckbox.setBackgroundResource(R.drawable.bg_checkbox_unchecked);

            skillsContainer.addView(item);
        }
    }

    void toggleSelection(int projectId) {
        isSelected = !isSelected;

        if (isSelected) {
            // Envoyer la sélection à l'API
            ApiService api = RetrofitClient.getApiService(this);
            SelectionRequest request = new SelectionRequest(projectId, 1);

            api.selectProject(request).enqueue(new Callback<Void>() {
                @Override
                public void onResponse(Call<Void> call, Response<Void> response) {
                    if (response.isSuccessful()) {
                        btnSelectProject.setText("✅  Project Selected");
                        btnSelectProject.setBackgroundResource(R.drawable.bg_btn_selected);
                        Toast.makeText(ProjectDetailActivity.this,
                                "Projet ajouté à ta sélection !",
                                Toast.LENGTH_SHORT).show();
                        setResult(RESULT_OK, getIntent());
                    } else {
                        // Remettre à l'état initial si erreur
                        isSelected = false;
                        Toast.makeText(ProjectDetailActivity.this,
                                "Erreur : " + response.code(),
                                Toast.LENGTH_SHORT).show();
                    }
                }

                @Override
                public void onFailure(Call<Void> call, Throwable t) {
                    isSelected = false;
                    Toast.makeText(ProjectDetailActivity.this,
                            "Erreur réseau",
                            Toast.LENGTH_SHORT).show();
                }
            });

        } else {
            // Désélectionner
            btnSelectProject.setText("⭐  Select this project");
            btnSelectProject.setBackgroundResource(R.drawable.bg_btn_login);
            Toast.makeText(this,
                    "Projet retiré de ta sélection",
                    Toast.LENGTH_SHORT).show();
            setResult(RESULT_CANCELED, getIntent());
        }
    }
package com.example.master_topic;

import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;
import androidx.appcompat.app.AppCompatActivity;
import androidx.cardview.widget.CardView;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import com.example.master_topic.adapters.ProjectAdapter;
import com.example.master_topic.api.ApiService;
import com.example.master_topic.api.RetrofitClient;
import com.example.master_topic.models.Project;
import java.util.List;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class DashboardActivity extends AppCompatActivity {

    TextView tvHello, tvLogout, tvSpecialityChosen, tvChooseProjects;
    CardView cardSpeciality, cardCreateProject;
    LinearLayout projectsContainer;
    RecyclerView recyclerProjects;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);

        // Init vues
        tvHello            = findViewById(R.id.tvHello);
        tvLogout           = findViewById(R.id.tvLogout);
        tvSpecialityChosen = findViewById(R.id.tvSpecialityChosen);
        tvChooseProjects   = findViewById(R.id.tvChooseProjects);
        cardSpeciality     = findViewById(R.id.cardSpeciality);
        cardCreateProject  = findViewById(R.id.cardCreateProject);
        projectsContainer  = findViewById(R.id.projectsContainer);

        // Récupérer nom et rôle depuis MainActivity
        String name = getIntent().getStringExtra("name");
        String role = getIntent().getStringExtra("role");

        if (name != null && !name.isEmpty()) {
            tvHello.setText("Hi, " + name);
        }

        // Professeur = Create project visible
        if ("Professor".equals(role)) {
            cardCreateProject.setVisibility(View.VISIBLE);
        } else {
            cardCreateProject.setVisibility(View.GONE);
        }

        // Bouton Speciality
        cardSpeciality.setOnClickListener(v -> {
            SpecialityDialog dialog = new SpecialityDialog(this, speciality -> {
                tvSpecialityChosen.setText("📚 " + speciality);
                Toast.makeText(this, "Spécialité : " + speciality, Toast.LENGTH_SHORT).show();

                // Afficher les projets uniquement pour l'étudiant
                if (!"Professor".equals(role)) {
                    tvChooseProjects.setVisibility(View.VISIBLE);
                    projectsContainer.setVisibility(View.VISIBLE);
                    chargerProjetsDepuisApi();
                }
            });
            dialog.show();
        });

        // Bouton Create Project
        cardCreateProject.setOnClickListener(v -> {
            Intent intent = new Intent(this, CreateProjectActivity.class);
            startActivity(intent);
        });

        // Déconnexion
        tvLogout.setOnClickListener(v -> {
            // Effacer le token
            SharedPreferences prefs = getSharedPreferences("UniProject", MODE_PRIVATE);
            prefs.edit().clear().apply();

            Intent intent = new Intent(this, MainActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            finish();
        });
    }

    // Remplace afficherProjets() par un vrai appel API
    void chargerProjetsDepuisApi() {
        ApiService api = RetrofitClient.getApiService(this);

        api.getProjects().enqueue(new Callback<List<Project>>() {
            @Override
            public void onResponse(Call<List<Project>> call, Response<List<Project>> response) {
                if (response.isSuccessful() && response.body() != null) {
                    List<Project> projects = response.body();

                    // Créer un RecyclerView dynamiquement
                    RecyclerView recyclerView = new RecyclerView(DashboardActivity.this);
                    recyclerView.setLayoutManager(new LinearLayoutManager(DashboardActivity.this));
                    ProjectAdapter adapter = new ProjectAdapter(DashboardActivity.this, projects);
                    recyclerView.setAdapter(adapter);

                    // Ajouter le RecyclerView dans le container
                    projectsContainer.removeAllViews();
                    projectsContainer.addView(recyclerView);

                } else {
                    Toast.makeText(DashboardActivity.this,
                            "Erreur : " + response.code(),
                            Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<List<Project>> call, Throwable t) {
                Toast.makeText(DashboardActivity.this,
                        "Erreur réseau",
                        Toast.LENGTH_SHORT).show();
            }
        });
    }
}
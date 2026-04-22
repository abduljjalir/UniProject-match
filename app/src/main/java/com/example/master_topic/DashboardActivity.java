package com.example.master_topic;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.cardview.widget.CardView;

public class DashboardActivity extends AppCompatActivity {

    TextView tvHello, tvLogout, tvSpecialityChosen, tvChooseProjects;
    CardView cardSpeciality, cardCreateProject;
    LinearLayout projectsContainer;

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

        // Récupérer les données de MainActivity
        String name = getIntent().getStringExtra("name");
        String role = getIntent().getStringExtra("role");

        // Afficher le nom
        if (name != null && !name.isEmpty()) {
            tvHello.setText("Hi, " + name);
        }

        // Professeur = Speciality + Create project
        // Étudiant   = Speciality seulement
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
                    afficherProjets();
                }
            });
            dialog.show();
        });

        // Bouton Create Project (professeur)
        cardCreateProject.setOnClickListener(v -> {
            Intent intent = new Intent(this, CreateProjectActivity.class);
            startActivity(intent);
        });

        // Déconnexion
        tvLogout.setOnClickListener(v -> {
            Intent intent = new Intent(this, MainActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
            finish();
        });
    }

    // ← En dehors de onCreate, avant la dernière accolade
    void afficherProjets() {
        projectsContainer.removeAllViews();

        // Données fictives — à remplacer par BDD plus tard
        String[] projets = {
                "AI Research",
                "Web Development",
                "Data Mining",
                "Network Security",
                "Machine Learning"
        };

        for (int i = 0; i < projets.length; i++) {
            final String projet = projets[i];
            View item = LayoutInflater.from(this)
                    .inflate(R.layout.item_project, projectsContainer, false);
            TextView tvNum   = item.findViewById(R.id.tvProjectNum);
            TextView tvTitle = item.findViewById(R.id.tvProjectTitle);
            tvNum.setText(String.valueOf(i + 1));
            tvTitle.setText(projet);

            // Clic → ouvrir le détail
            item.setOnClickListener(v -> {
                Intent intent = new Intent(this, ProjectDetailActivity.class);
                intent.putExtra("projectTitle", projet);
                intent.putExtra("projectDesc", "Description fictive du projet " + projet + ". À remplacer par les données de la base.");
                startActivity(intent);
            });

            projectsContainer.addView(item);
        }
    }
}
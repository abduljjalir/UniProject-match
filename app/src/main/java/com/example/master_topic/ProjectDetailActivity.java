package com.example.master_topic; // ⚠️ Vérifie ton package

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

public class ProjectDetailActivity extends AppCompatActivity {

    TextView tvProjectTitle, tvProjectDesc, btnBack;
    LinearLayout skillsContainer;
    Button btnSelectProject;

    boolean isSelected = false;

    // Données fictives skills — à remplacer par BDD plus tard
    String[] skills = {"Python", "Machine Learning", "TensorFlow", "Data Analysis"};
    boolean[] skillsChecked;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_project_detail);

        // Init vues
        tvProjectTitle  = findViewById(R.id.tvProjectTitle);
        tvProjectDesc   = findViewById(R.id.tvProjectDesc);
        skillsContainer = findViewById(R.id.skillsContainer);
        btnSelectProject = findViewById(R.id.btnSelectProject);
        btnBack         = findViewById(R.id.btnBack);

        // Récupérer les données du projet cliqué
        String title = getIntent().getStringExtra("projectTitle");
        String desc  = getIntent().getStringExtra("projectDesc");

        if (title != null) tvProjectTitle.setText(title);
        if (desc  != null) tvProjectDesc.setText(desc);

        // Init tableau cochés
        skillsChecked = new boolean[skills.length];

        // Afficher les skills
        afficherSkills();

        // Retour
        btnBack.setOnClickListener(v -> finish());

        // Bouton sélection
        btnSelectProject.setOnClickListener(v -> toggleSelection());
    }

    void afficherSkills() {
        skillsContainer.removeAllViews();

        for (int i = 0; i < skills.length; i++) {
            final int index = i;

            View item = LayoutInflater.from(this)
                    .inflate(R.layout.item_skill_check, skillsContainer, false);

            TextView tvCheckbox = item.findViewById(R.id.tvCheckbox);
            TextView tvSkillName = item.findViewById(R.id.tvSkillName);

            tvSkillName.setText(skills[i]);
            updateCheckbox(tvCheckbox, skillsChecked[i]);

            // Clic sur le skill → cocher/décocher
            item.setOnClickListener(v -> {
                skillsChecked[index] = !skillsChecked[index];
                updateCheckbox(tvCheckbox, skillsChecked[index]);
            });

            skillsContainer.addView(item);
        }
    }

    void updateCheckbox(TextView tvCheckbox, boolean checked) {
        if (checked) {
            tvCheckbox.setText("✓");
            tvCheckbox.setBackgroundResource(R.drawable.bg_checkbox_checked);
        } else {
            tvCheckbox.setText("");
            tvCheckbox.setBackgroundResource(R.drawable.bg_checkbox_unchecked);
        }
    }

    void toggleSelection() {
        isSelected = !isSelected;

        if (isSelected) {
            // Projet sélectionné → bouton vert
            btnSelectProject.setText("✅  Project Selected");
            btnSelectProject.setBackgroundResource(R.drawable.bg_btn_selected);
            Toast.makeText(this, "Projet ajouté à ta sélection !", Toast.LENGTH_SHORT).show();

            // Retourner le résultat au dashboard
            getIntent().putExtra("selected", true);
            setResult(RESULT_OK, getIntent());
        } else {
            // Désélectionné → bouton bleu
            btnSelectProject.setText("⭐  Select this project");
            btnSelectProject.setBackgroundResource(R.drawable.bg_btn_login);
            Toast.makeText(this, "Projet retiré de ta sélection", Toast.LENGTH_SHORT).show();
            setResult(RESULT_CANCELED, getIntent());
        }
    }
}

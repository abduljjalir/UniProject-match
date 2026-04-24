package com.example.master_topic; // ⚠️ Vérifie ton package

import android.app.Dialog;
import android.content.Context;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.Window;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.util.Arrays;
import java.util.List;

public class SpecialityDialog extends Dialog {

    // Interface pour récupérer la spécialité choisie
    public interface OnSpecialitySelectedListener {
        void onSelected(String speciality);
    }

    private OnSpecialitySelectedListener listener;

    // Liste des spécialités disponibles (à remplacer par BDD plus tard)
    private final List<String> specialities = Arrays.asList(
            "💻  Computer Science",
            "📊  Data Science",
            "🔐  Cybersecurity",
            "🌐  Networks",
            "📱  Mobile Development",
            "🤖  Artificial Intelligence"
    );

    public SpecialityDialog(Context context, OnSpecialitySelectedListener listener) {
        super(context);
        this.listener = listener;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        // Fenêtre sans titre
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        setContentView(R.layout.dialog_speciality);

        // Fond transparent pour voir les coins arrondis
        if (getWindow() != null) {
            getWindow().setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));
            getWindow().setLayout(
                    (int) (getContext().getResources().getDisplayMetrics().widthPixels * 0.88),
                    android.view.ViewGroup.LayoutParams.WRAP_CONTENT
            );
        }

        // Titre du dialog
        TextView tvTitle = findViewById(R.id.tvDialogTitle);
        tvTitle.setText("Choose Your Speciality");

        // Container des spécialités
        LinearLayout container = findViewById(R.id.specialityContainer);

        for (String spec : specialities) {
            // Inflater chaque ligne
            View item = LayoutInflater.from(getContext())
                    .inflate(R.layout.item_speciality, container, false);

            TextView tvName = item.findViewById(R.id.tvSpecName);
            // Séparer l'emoji du texte
            String[] parts = spec.split("  ", 2);
            TextView tvIcon = item.findViewById(R.id.tvSpecIcon);
            if (parts.length == 2) {
                tvIcon.setText(parts[0]);
                tvName.setText(parts[1]);
            } else {
                tvName.setText(spec);
            }

            // Clic sur une spécialité
            item.setOnClickListener(v -> {
                String selected = parts.length == 2 ? parts[1] : spec;
                if (listener != null) listener.onSelected(selected);
                dismiss();
            });

            container.addView(item);

            // Séparateur
            if (specialities.indexOf(spec) < specialities.size() - 1) {
                View divider = new View(getContext());
                LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                        LinearLayout.LayoutParams.MATCH_PARENT, 1
                );
                params.setMarginStart(64);
                divider.setLayoutParams(params);
                divider.setBackgroundColor(0xFFEEF3F8);
                container.addView(divider);
            }
        }

        // Bouton fermer
        TextView tvCancel = findViewById(R.id.tvDialogCancel);
        tvCancel.setOnClickListener(v -> dismiss());
    }
}

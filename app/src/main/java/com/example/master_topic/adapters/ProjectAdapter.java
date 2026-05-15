package com.example.master_topic.adapters;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;
import com.example.master_topic.ProjectDetailActivity;
import com.example.master_topic.R;
import com.example.master_topic.models.Project;
import java.util.List;

public class ProjectAdapter extends RecyclerView.Adapter<ProjectAdapter.ProjectViewHolder> {

    private List<Project> projects;
    private Context context;

    public ProjectAdapter(Context context, List<Project> projects) {
        this.context = context;
        this.projects = projects;
    }

    @NonNull
    @Override
    public ProjectViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_project, parent, false);
        return new ProjectViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull ProjectViewHolder holder, int position) {
        Project project = projects.get(position);

        holder.tvNum.setText(String.valueOf(position + 1));
        holder.tvTitle.setText(project.getTitle());

        // Clic → ouvrir le détail
        holder.itemView.setOnClickListener(v -> {
            Intent intent = new Intent(context, ProjectDetailActivity.class);
            intent.putExtra("projectId", project.getId());
            intent.putExtra("projectTitle", project.getTitle());
            intent.putExtra("projectDesc", project.getDescription());
            context.startActivity(intent);
        });
    }

    @Override
    public int getItemCount() {
        return projects.size();
    }

    public static class ProjectViewHolder extends RecyclerView.ViewHolder {
        TextView tvNum, tvTitle;

        public ProjectViewHolder(@NonNull View itemView) {
            super(itemView);
            tvNum   = itemView.findViewById(R.id.tvProjectNum);
            tvTitle = itemView.findViewById(R.id.tvProjectTitle);
        }
    }
}
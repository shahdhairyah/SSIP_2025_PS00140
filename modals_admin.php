<?php
// This file contains all modal definitions
// It is included at the bottom of admin.php
?>

<!-- Add Project Modal -->
<div class="modal fade" id="addProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_project">
                    <input type="hidden" name="database" value="<?php echo $selectedDb; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Project Name</label>
                        <input type="text" class="form-control" name="project_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="department" required>
                            <?php foreach($departments as $dept): ?>
                            <option value="<?php echo htmlspecialchars($dept['name']); ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <input type="date" class="form-control" name="deadline" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Budget</label>
                        <input type="number" class="form-control" name="budget" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="On Track">On Track</option>
                            <option value="Delayed">Delayed</option>
                            <option value="At Risk">At Risk</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Progress (%)</label>
                        <input type="number" class="form-control" name="progress" min="0" max="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<!-- <div class="modal fade" id="editProjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_project">
                    <input type="hidden" name="database" value="<?php echo $selectedDb; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Project ID</label>
                        <input type="text" class="form-control" name="id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Project Name</label>
                        <input type="text" class="form-control" name="project_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="department" required>
                            <?php foreach($departments as $dept): ?>
                            <option value="<?php echo htmlspecialchars($dept['name']); ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <input type="date" class="form-control" name="deadline" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Budget</label>
                        <input type="text" class="form-control" name="budget" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                            <option value="On Track">On Track</option>
                            <option value="Delayed">Delayed</option>
                            <option value="At Risk">At Risk</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Progress (%)</label>
                        <input type="number" class="form-control" name="progress" min="0" max="100" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Project</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!-- Add Notification Modal -->
<div class="modal fade" id="addNotificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_notification">
                    <input type="hidden" name="database" value="<?php echo $selectedDb; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="department">
                            <option value="">Select Department</option>
                            <?php foreach($departments as $dept): ?>
                            <option value="<?php echo htmlspecialchars($dept['name']); ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control" name="icon" placeholder="e.g., document, calendar, stats">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Notification Modal -->
<div class="modal fade" id="editNotificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_notification">
                    <input type="hidden" name="database" value="<?php echo $selectedDb; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Notification ID</label>
                        <input type="text" class="form-control" name="id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="department">
                            <option value="">Select Department</option>
                            <?php foreach($departments as $dept): ?>
                            <option value="<?php echo htmlspecialchars($dept['name']); ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control" name="icon" placeholder="e.g., document, calendar, stats">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Metrics Modal -->
<div class="modal fade" id="addMetricesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Dashboard Metrics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="add_metrices">
                    <input type="hidden" name="database" value="<?php echo $selectedDb; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Metric Name</label>
                        <input type="text" class="form-control" name="metric_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metric Value</label>
                        <input type="text" class="form-control" name="metric_value" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="department">
                            <option value="">Select Department</option>
                            <?php foreach($departments as $dept): ?>
                            <option value="<?php echo htmlspecialchars($dept['name']); ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control" name="icon" placeholder="e.g., bi-building, bi-people, bi-journal-text, bi-graph-up">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Metrics</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Metrics Modal -->
<div class="modal fade" id="editMetricesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Dashboard Metrics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit_metrices">
                    <input type="hidden" name="database" value="<?php echo $selectedDb; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Metric ID</label>
                        <input type="text" class="form-control" name="id" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metric Name</label>
                        <input type="text" class="form-control" name="metric_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metric Value</label>
                        <input type="text" class="form-control" name="metric_value" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Department</label>
                        <select class="form-control" name="department">
                            <option value="">Select Department</option>
                            <?php foreach($departments as $dept): ?>
                            <option value="<?php echo htmlspecialchars($dept['name']); ?>"><?php echo htmlspecialchars($dept['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control" name="icon" placeholder="e.g., bi-building,bi-people,bi-journal-text,bi-graph-up">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Metrics</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include_once ('header.php');
include ('../includes/db_connect.php');
include('side_content.php');

// Pagination configuration
$results_per_page = 15; // Number of results per page

// Get current page number
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Calculate offset
$offset = ($page - 1) * $results_per_page;

// Get total number of contacts
$total_result = $db->query("SELECT COUNT(*) as total FROM contact");
$total_row = $total_result->fetch_assoc();
$total_contacts = $total_row['total'];

// Calculate total pages
$total_pages = ceil($total_contacts / $results_per_page);

// Ensure page doesn't exceed total pages
if ($page > $total_pages && $total_pages > 0) {
    $page = $total_pages;
}

// Handle delete actions
if(isset($_GET['action'])){
    if($_GET['action'] == 'delete'){
        $contact_id = (int)$_GET['contact_id'];
        $delete = $db->query("DELETE FROM `contact` WHERE `contact`.`contact_id` = $contact_id");
    
        if($delete){
            $_SESSION['alert'] = "Contact deleted successfully";
            $_SESSION['alert_code'] = "success";
            $_SESSION['alert_link'] = "contact-form.php?page=" . $page;
            
            // Redirect to avoid resubmission on refresh
            header("Location: contact-form.php?page=" . $page);
            exit();
        }
    } elseif($_GET['action'] == 'delete_multiple' && isset($_POST['selected_contacts'])) {
        // Handle multiple deletion
        $selected_contacts = $_POST['selected_contacts'];
        $contact_ids = implode(',', array_map('intval', $selected_contacts));
        
        $delete_multiple = $db->query("DELETE FROM `contact` WHERE `contact`.`contact_id` IN ($contact_ids)");
    
        if($delete_multiple){
            $_SESSION['alert'] = count($selected_contacts) . " contact(s) deleted successfully";
            $_SESSION['alert_code'] = "success";
            $_SESSION['alert_link'] = "contact-form.php?page=" . $page;
            
            // Redirect to avoid resubmission on refresh
            header("Location: contact-form.php?page=" . $page);
            exit();
        }
    }       
}

// Fetch contacts for current page with optimized query
$result_contact = $db->query("SELECT contact_id, contact_name, contact_email, contact_message FROM contact ORDER BY contact_id DESC LIMIT $offset, $results_per_page");

?>
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa fa-bars"></i> Contact Form Data</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-bars"></i>Contact Form Data</li>
            </ol>
          </div>
        </div>
        <!-- page start-->
        <div class="row">
            <div class="col-md-12">
                <h2>Contact Form Data</h2>
                <p>Total: <?= $total_contacts ?> contact submissions</p>
            </div>
        </div>
        
        <!-- Add a form for multiple selection -->
        <form id="multiDeleteForm" method="post" action="?action=delete_multiple&page=<?= $page ?>">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="deleteSelected" class="btn btn-danger" disabled onclick="confirmMultiDelete()">
                        <i class="fa fa-trash"></i> Delete Selected
                    </button>
                    <button type="button" id="selectAll" class="btn btn-default" onclick="toggleSelectAll(this)">
                        Select All
                    </button>
                </div>
            </div>
            <br>
            
            <div class="row">
                <div class="col-lg-1 col-md-1"></div>
                <div class="col-lg-10 col-md-10">
                    <h3>Content Table</h3>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="50px">
                                    <input type="checkbox" id="masterCheckbox" onclick="toggleAllCheckboxes(this)">
                                </th>
                                <th>No</th>
                                <th>Names</th>
                                <th>Email</th>
                                <th>Comments</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = ($page - 1) * $results_per_page + 1;
                        if ($result_contact->num_rows > 0) {
                            while($contact = $result_contact->fetch_assoc()): 
                        ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="selected_contacts[]" value="<?= $contact['contact_id'] ?>" class="contact-checkbox" onclick="updateDeleteButton()">
                                </td>
                                <td><?=$count++?></td>
                                <td><?=htmlspecialchars($contact['contact_name'])?></td>
                                <td><?=htmlspecialchars($contact['contact_email'])?></td>
                                <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;" title="<?=htmlspecialchars($contact['contact_message'])?>">
                                    <?=strlen($contact['contact_message']) > 100 ? substr(htmlspecialchars($contact['contact_message']), 0, 100) . '...' : htmlspecialchars($contact['contact_message'])?>
                                </td>
                                <td> 
                                    <a href="?contact_id=<?=$contact['contact_id']?>&action=delete&page=<?=$page?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Are you sure you want to delete this contact?')">Delete</a>
                                </td>
                            </tr>
                        <?php 
                            endwhile;
                        } else {
                            echo '<tr><td colspan="6" class="text-center">No contact submissions found</td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <div class="text-center">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li><a href="?page=1">&laquo; First</a></li>
                                <li><a href="?page=<?= $page - 1 ?>">Previous</a></li>
                            <?php endif; ?>
                            
                            <?php
                            // Show page numbers with ellipsis for many pages
                            $start_page = max(1, $page - 2);
                            $end_page = min($total_pages, $page + 2);
                            
                            if ($start_page > 1) {
                                echo '<li><a href="?page=1">1</a></li>';
                                if ($start_page > 2) echo '<li class="disabled"><span>...</span></li>';
                            }
                            
                            for ($i = $start_page; $i <= $end_page; $i++):
                            ?>
                                <li class="<?= $i == $page ? 'active' : '' ?>">
                                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                          <?php  if ($end_page < $total_pages) {
                                if ($end_page < $total_pages - 1){
                                echo '<li class="disabled"><span>...</span></li>';
                                echo '<li><a href="?page='.$total_pages.'">'.$total_pages.'</a></li>';
                                }
                            }
                            ?>
                            
                            <?php if ($page < $total_pages): ?>
                                <li><a href="?page=<?= $page + 1 ?>">Next</a></li>
                                <li><a href="?page=<?= $total_pages ?>">Last &raquo;</a></li>
                            <?php endif; ?>
                        </ul>
                        
                        <p>Page <?= $page ?> of <?= $total_pages ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <!-- /. ROW  -->
        <!-- page end-->
      </section>
    </section>
</section>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the selected contacts? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="submitMultiDelete()">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
// Function to toggle all checkboxes
function toggleAllCheckboxes(source) {
    var checkboxes = document.getElementsByClassName('contact-checkbox');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
    updateDeleteButton();
    updateSelectAllButton();
}

// Function to toggle select all button text
function toggleSelectAll(button) {
    var checkboxes = document.getElementsByClassName('contact-checkbox');
    var allChecked = true;
    
    for (var i = 0; i < checkboxes.length; i++) {
        if (!checkboxes[i].checked) {
            allChecked = false;
            break;
        }
    }
    
    if (allChecked) {
        // If all are checked, uncheck all
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
        button.textContent = "Select All";
    } else {
        // If not all are checked, check all
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = true;
        }
        button.textContent = "Deselect All";
    }
    
    document.getElementById('masterCheckbox').checked = !allChecked;
    updateDeleteButton();
}

// Function to update the delete button state
function updateDeleteButton() {
    var checkboxes = document.getElementsByClassName('contact-checkbox');
    var checkedCount = 0;
    
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checkedCount++;
        }
    }
    
    var deleteButton = document.getElementById('deleteSelected');
    if (checkedCount > 0) {
        deleteButton.disabled = false;
        deleteButton.innerHTML = '<i class="fa fa-trash"></i> Delete Selected (' + checkedCount + ')';
    } else {
        deleteButton.disabled = true;
        deleteButton.innerHTML = '<i class="fa fa-trash"></i> Delete Selected';
    }
    
    // Update master checkbox
    document.getElementById('masterCheckbox').checked = (checkedCount === checkboxes.length && checkboxes.length > 0);
    updateSelectAllButton();
}

// Function to update select all button text
function updateSelectAllButton() {
    var checkboxes = document.getElementsByClassName('contact-checkbox');
    var allChecked = true;
    
    for (var i = 0; i < checkboxes.length; i++) {
        if (!checkboxes[i].checked) {
            allChecked = false;
            break;
        }
    }
    
    var selectAllButton = document.getElementById('selectAll');
    if (allChecked && checkboxes.length > 0) {
        selectAllButton.textContent = "Deselect All";
    } else {
        selectAllButton.textContent = "Select All";
    }
}

// Function to show confirmation modal
function confirmMultiDelete() {
    $('#confirmDeleteModal').modal('show');
}

// Function to submit the delete form
function submitMultiDelete() {
    document.getElementById('multiDeleteForm').submit();
}

// Initialize button state on page load
document.addEventListener('DOMContentLoaded', function() {
    updateDeleteButton();
});
</script>
   
<?php include_once ('footer.php');?>
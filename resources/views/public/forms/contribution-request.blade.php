<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Funding - YB Dato' Zunita Begum</title>
    
    <!-- McKinsey Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Georgia:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --mckinsey-navy: #0f1419;
            --mckinsey-blue: #1f4e79;
            --mckinsey-teal: #0078d4;
            --mckinsey-gold: #ffb900;
            --mckinsey-gray: #6e6e6e;
            --mckinsey-light-gray: #f3f2f1;
            --mckinsey-white: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: var(--mckinsey-navy); line-height: 1.6; background-color: var(--mckinsey-light-gray); min-height: 100vh; }
        .header { background: white; border-bottom: 1px solid var(--mckinsey-light-gray); padding: 1rem 0; position: sticky; top: 0; z-index: 100; }
        .header-container { max-width: 800px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; }
        .brand { font-family: 'Georgia', serif; font-size: 1.5rem; font-weight: 700; color: var(--mckinsey-navy); }
        .back-link { color: var(--mckinsey-blue); text-decoration: none; font-weight: 600; }
        .main { max-width: 800px; margin: 2rem auto; padding: 0 2rem; }
        .form-container { background: white; border-radius: 8px; padding: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-title { font-family: 'Georgia', serif; font-size: 2rem; font-weight: 400; color: var(--mckinsey-navy); margin-bottom: 0.5rem; }
        .form-description { color: var(--mckinsey-gray); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--mckinsey-navy); }
        .form-input, .form-select, .form-textarea { width: 100%; padding: 0.75rem; border: 1px solid var(--mckinsey-light-gray); border-radius: 4px; font-size: 1rem; transition: border-color 0.2s; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: var(--mckinsey-blue); }
        .form-textarea { resize: vertical; min-height: 120px; }
        .form-help { color: var(--mckinsey-gray); font-size: 0.875rem; margin-top: 0.25rem; }
        .btn-group { display: flex; gap: 1rem; margin-top: 2rem; }
        .btn-primary { background: var(--mckinsey-blue); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-primary:hover { background: var(--mckinsey-navy); }
        .btn-secondary { background: var(--mckinsey-light-gray); color: var(--mckinsey-navy); padding: 0.75rem 1.5rem; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .btn-secondary:hover { background: var(--mckinsey-gray); color: white; }
        .error-message { color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; }
        .file-upload { border: 2px dashed var(--mckinsey-light-gray); border-radius: 4px; padding: 2rem; text-align: center; cursor: pointer; transition: border-color 0.2s; }
        .file-upload:hover { border-color: var(--mckinsey-blue); }
        .file-upload input[type="file"] { display: none; }
        @media (max-width: 768px) { .header-container, .main { padding: 0 1rem; } .form-container { padding: 1.5rem; } .btn-group { flex-direction: column; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="brand">YB Dato' Zunita Begum</div>
            <a href="{{ route('public.dashboard') }}" class="back-link">← Back to Dashboard</a>
        </div>
    </header>

    <main class="main">
        <div class="form-container">
            <h1 class="form-title">Request Program Funding</h1>
            <p class="form-description">
                Request funding support for community programs, events, or initiatives that benefit the constituency.
            </p>

            <form method="POST" action="{{ route('public.forms.contribution.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label class="form-label">Program/Event Type</label>
                    <select name="type" class="form-select" required>
                        <option value="">Select type</option>
                        <option value="community_event">Community Event</option>
                        <option value="educational">Educational Program</option>
                        <option value="religious">Religious Activity</option>
                        <option value="sports">Sports & Recreation</option>
                        <option value="charity">Charity/NGO Program</option>
                        <option value="cultural">Cultural/Arts Program</option>
                        <option value="other">Other</option>
                    </select>
                    @error('type') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Program/Event Name</label>
                    <input type="text" name="program_name" class="form-input" placeholder="Name of your program or event" required>
                    @error('program_name') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-input" placeholder="Where will this take place?" required>
                    @error('location') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-input" required>
                    @error('date') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Amount Requested (RM)</label>
                    <input type="number" name="amount_requested" class="form-input" placeholder="0.00" min="0" step="0.01" required>
                    @error('amount_requested') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Expected Attendance</label>
                    <input type="number" name="expected_attendance" class="form-input" placeholder="Number of people expected" min="1" required>
                    @error('expected_attendance') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Program Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Describe your program/event in detail..." required></textarea>
                    @error('description') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Budget Breakdown</label>
                    <textarea name="budget_breakdown" class="form-textarea" placeholder="Provide a detailed breakdown of how the funds will be used..." required></textarea>
                    @error('budget_breakdown') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Supporting Documents</label>
                    <div class="file-upload">
                        <input type="file" name="documents[]" multiple accept=".jpg,.jpeg,.png,.pdf">
                        <p>Click to upload or drag files here</p>
                        <p class="form-help">Include: Program proposal, budget, photos, invitation letters (Max 5MB each)</p>
                    </div>
                    @error('documents.*') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-primary">Submit Request</button>
                    <a href="{{ route('public.dashboard') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
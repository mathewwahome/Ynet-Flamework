<!DOCTYPE html>
<html>
<head>
    <title>Ynet Form Builder</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.css" rel="stylesheet">
    <style>
        .form-builder-container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }
        
        .components-list {
            width: 250px;
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        
        .form-preview {
            flex: 1;
            background: white;
            padding: 20px;
            border: 1px dashed #ccc;
            min-height: 400px;
        }
        
        .component-item {
            background: white;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            cursor: move;
        }
        
        .form-component {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #eee;
            position: relative;
        }
        
        .component-controls {
            position: absolute;
            right: 5px;
            top: 5px;
        }
        
        .settings-panel {
            width: 300px;
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            margin: 4px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        button {
            padding: 8px 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-builder-container">
        <div class="components-list">
            <h3>Form Components</h3>
            <div class="component-item" data-type="text">Text Input</div>
            <div class="component-item" data-type="textarea">Text Area</div>
            <div class="component-item" data-type="number">Number</div>
            <div class="component-item" data-type="email">Email</div>
            <div class="component-item" data-type="select">Dropdown</div>
            <div class="component-item" data-type="checkbox">Checkbox</div>
            <div class="component-item" data-type="radio">Radio Button</div>
            <div class="component-item" data-type="date">Date</div>
            <div class="component-item" data-type="file">File Upload</div>
        </div>

        <div class="form-preview">
            <h3>Form Preview</h3>
            <div id="formContainer"></div>
        </div>

        <div class="settings-panel">
            <h3>Component Settings</h3>
            <div id="componentSettings"></div>
            
            <div class="form-settings" style="margin-top: 20px;">
                <h4>Form Settings</h4>
                <div class="form-group">
                    <label>Form Name:</label>
                    <input type="text" id="formName" class="form-control">
                </div>
                <div class="form-group">
                    <label>Table Name:</label>
                    <input type="text" id="tableName" class="form-control">
                </div>
                <button onclick="saveForm()">Save Form</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const drake = dragula([
        document.querySelector('.components-list'),
        document.querySelector('#formContainer')
    ], {
        copy: function(el, source) {
            return source.classList.contains('components-list');
        },
        accepts: function(el, target) {
            return target.id === 'formContainer';
        }
    });

    drake.on('drop', function(el, target, source) {
        if (target && target.id === 'formContainer' && source.classList.contains('components-list')) {
            const type = el.getAttribute('data-type');
            const id = 'field_' + Math.random().toString(36).substr(2, 9);
            
            // Create new element
            const newEl = document.createElement('div');
            newEl.className = 'form-component';
            newEl.setAttribute('data-field-id', id);
            newEl.setAttribute('data-field-type', type);
            newEl.innerHTML = getComponentHTML(type, id);

            // Append the new element to formContainer
            target.appendChild(newEl);

            // Remove the placeholder dragged element
            el.remove();
        }
    });
});


        function getComponentHTML(type, id) {
            const controls = `
                <div class="component-controls">
                    <button onclick="editComponent('${id}')">Edit</button>
                    <button onclick="removeComponent('${id}')">Remove</button>
                </div>
            `;

            switch(type) {
                case 'text':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>Text Input</label>
                            <input type="text" class="form-control" placeholder="Enter text">
                        </div>
                    `;
                case 'textarea':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>Text Area</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                    `;
                case 'number':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>Number Input</label>
                            <input type="number" class="form-control" placeholder="Enter number">
                        </div>
                    `;
                case 'email':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>Email Input</label>
                            <input type="email" class="form-control" placeholder="Enter email">
                        </div>
                    `;
                case 'select':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>Dropdown</label>
                            <select class="form-control">
                                <option>Option 1</option>
                                <option>Option 2</option>
                                <option>Option 3</option>
                            </select>
                        </div>
                    `;
                case 'checkbox':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="form-check-input">
                                Checkbox Option
                            </label>
                        </div>
                    `;
                case 'radio':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>Radio Options</label><br>
                            <label>
                                <input type="radio" name="radio_${id}" value="1">
                                Option 1
                            </label><br>
                            <label>
                                <input type="radio" name="radio_${id}" value="2">
                                Option 2
                            </label>
                        </div>
                    `;
                case 'date':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>Date Input</label>
                            <input type="date" class="form-control">
                        </div>
                    `;
                case 'file':
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>File Upload</label>
                            <input type="file" class="form-control">
                        </div>
                    `;
                default:
                    return `
                        ${controls}
                        <div class="form-group">
                            <label>Unknown Component</label>
                            <input type="text" class="form-control">
                        </div>
                    `;
            }
        }

        function editComponent(id) {
            const component = document.querySelector(`[data-field-id="${id}"]`);
            const type = component.getAttribute('data-field-type');
            const settings = document.getElementById('componentSettings');
            
            settings.innerHTML = `
                <div class="form-group">
                    <label>Field Label:</label>
                    <input type="text" class="field-label form-control" value="${component.querySelector('label').textContent}">
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" class="field-required">
                        Required Field
                    </label>
                </div>
                ${getTypeSpecificSettings(type)}
                <button onclick="updateComponent('${id}')">Update</button>
            `;
        }

        function getTypeSpecificSettings(type) {
            switch(type) {
                case 'select':
                    return `
                        <div class="form-group">
                            <label>Options (one per line):</label>
                            <textarea class="field-options form-control" rows="4"></textarea>
                        </div>
                    `;
                case 'radio':
                    return `
                        <div class="form-group">
                            <label>Options (one per line):</label>
                            <textarea class="field-options form-control" rows="4"></textarea>
                        </div>
                    `;
                default:
                    return '';
            }
        }

        function removeComponent(id) {
            const component = document.querySelector(`[data-field-id="${id}"]`);
            component.remove();
        }

        function updateComponent(id) {
            const component = document.querySelector(`[data-field-id="${id}"]`);
            const label = document.querySelector('.field-label').value;
            const required = document.querySelector('.field-required').checked;
            const type = component.getAttribute('data-field-type');

            component.querySelector('label').textContent = label;
            
            // Update required attribute
            const input = component.querySelector('input, textarea, select');
            if (input) {
                if (required) {
                    input.setAttribute('required', 'required');
                } else {
                    input.removeAttribute('required');
                }
            }

            // Update options for select/radio if applicable
            if (type === 'select' || type === 'radio') {
                const options = document.querySelector('.field-options').value.split('\n');
                updateOptions(component, type, options);
            }
        }

        function updateOptions(component, type, options) {
            if (type === 'select') {
                const select = component.querySelector('select');
                select.innerHTML = options.map(opt => 
                    `<option value="${opt.trim()}">${opt.trim()}</option>`
                ).join('');
            } else if (type === 'radio') {
                const radioGroup = component.querySelector('.form-group');
                const name = component.querySelector('input[type="radio"]').name;
                radioGroup.innerHTML = `<label>Radio Options</label><br>` + 
                    options.map(opt => 
                        `<label>
                            <input type="radio" name="${name}" value="${opt.trim()}">
                            ${opt.trim()}
                        </label><br>`
                    ).join('');
            }
        }

        function saveForm() {
            const formData = {
                name: document.getElementById('formName').value,
                tableName: document.getElementById('tableName').value,
                fields: []
            };

            document.querySelectorAll('.form-component').forEach(component => {
                formData.fields.push({
                    type: component.getAttribute('data-field-type'),
                    name: component.querySelector('label').textContent.toLowerCase().replace(/\s+/g, '_'),
                    label: component.querySelector('label').textContent,
                    required: component.querySelector('input, textarea, select')?.hasAttribute('required') || false
                });
            });

            fetch('/form-builder/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Form saved successfully!');
                } else {
                    alert('Error: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Error saving form: ' + error.message);
            });
        }
    </script>
</body>
</html>
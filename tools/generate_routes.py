import os
import re

controllers_dir = "app/Controllers"
routes_output = "explicit_routes.php"

# Map to store routes: method -> [route_lines]
routes = []

def parse_controller(filepath, class_name, controller_name):
    with open(filepath, 'r') as f:
        content = f.read()

    # Find all public methods that start with get or post
    matches = re.finditer(r'public\s+function\s+(get|post)([A-Za-z0-9_]+)\s*\(([^)]*)\)', content)
    for match in matches:
        http_verb = match.group(1).lower()
        method_name = match.group(2)
        params_str = match.group(3)

        # Convert CamelCase method name back to uri path (lowercase, separated by nothing unless it's specific)
        # CI4 improved auto routing expects exact capitalization unless translateURIDashes is applied.
        # Often URL is simply lowercased method_name. 
        # For CI4 Improved Auto Routing without translation:
        # getIndex -> index
        # getManage -> manage
        # getDiscardSuspendedSale -> discardSuspendedSale (if it was camelCase in the UI)
        # For simplicity, we will output exactly what CI's AutoRouterImproved would do:
        # The URI segment is exactly the method name unless it's index.
        
        uri_segment = method_name
        
        # Determine number of parameters to add (:any)
        params_count = 0
        if params_str.strip():
            # count commas for number of params
            params_count = len(params_str.split(','))

        # Build route strings
        uri_base = controller_name.lower()
        
        # If method is Index, the route is just the controller name
        # We also map controller/index
        uris = []
        if method_name.lower() == 'index':
            uris.append(uri_base)
            uris.append(f"{uri_base}/index")
        else:
            # CodeIgniter 4 improved routing natively expects the exact URI matched:
            # We will use the exact method_name (camelCase retained, but usually lowercased in browser).
            # We'll map the exact method_name as typed but with a lowercased first letter.
            if len(uri_segment) > 0:
                uri_segment = uri_segment[0].lower() + uri_segment[1:]
            uris.append(f"{uri_base}/{uri_segment}")

        for uri in uris:
            param_str = ""
            controller_param_str = ""
            if params_count > 0:
                segments = []
                c_segments = []
                for i in range(params_count):
                    segments.append('(:any)')
                    c_segments.append(f"${i+1}")
                param_str = "/" + "/".join(segments)
                controller_param_str = "/" + "/".join(c_segments)

            route_line = f"$routes->{http_verb}('{uri}{param_str}', '{class_name}::{http_verb}{method_name}{controller_param_str}');"
            routes.append(route_line)

for filename in os.listdir(controllers_dir):
    if filename.endswith(".php"):
        class_name = filename[:-4]
        if class_name in ['BaseController', 'Secure_Controller', 'Config']: 
            continue # Config has its own routes or doesn't need them
            
        parse_controller(os.path.join(controllers_dir, filename), class_name, class_name)

with open(routes_output, 'w') as f:
    f.write("<?php\n// Auto-generated explicit routes\n")
    for r in routes:
        f.write(r + "\n")
print(f"Generated {len(routes)} routes.")

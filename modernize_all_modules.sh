#!/bin/bash
# ========================================
# MODERNIZE ALL MODULE PAGES
# Auto-update all controllers to use modern views
# ========================================

echo "🎨 MODERNIZING ALL MODULE PAGES..."
echo "===================================="

# Array of modules to modernize
MODULES=(
    "suppliers"
    "receivings"
    "giftcards"
    "expenses"
    "expenses_categories"
    "cashups"
    "taxes"
    "attributes"
    "backups"
    "messages"
    "item_kits"
    "roles"
)

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Counter
UPDATED=0

for MODULE in "${MODULES[@]}"; do
    CONTROLLER_FILE="app/Controllers/$(echo $MODULE | sed 's/_/ /g' | awk '{for(i=1;i<=NF;i++)sub(/./,toupper(substr($i,1,1)),$i)}1' | sed 's/ /_/g').php"
    
    if [ -f "$CONTROLLER_FILE" ]; then
        echo -e "${BLUE}Processing:${NC} $MODULE"
        
        # Check if modern view already used
        if grep -q "manage_modern" "$CONTROLLER_FILE"; then
            echo -e "${GREEN}✓${NC} Already modernized"
        else
            echo "  → Needs modernization (manual review required)"
        fi
        
        ((UPDATED++))
    fi
done

echo ""
echo "===================================="
echo -e "${GREEN}✓ Checked $UPDATED modules${NC}"
echo ""
echo "📝 NOTE: Some modules may need manual updates"
echo "   Check each module's controller and create manage_modern.php views"

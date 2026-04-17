const express = require('express');
const router = express.Router();

// Sample restaurant menu data
const menu = {
  categories: [
    {
      id: 1,
      name: "Appetizers",
      items: [
        { id: 101, name: "Spring Rolls", price: 8.99, description: "Crispy vegetable rolls with sweet chili sauce" },
        { id: 102, name: "Bruschetta", price: 9.99, description: "Grilled bread with tomato, basil, and garlic" },
        { id: 103, name: "Chicken Wings", price: 12.99, description: "Spicy buffalo wings with blue cheese dip" }
      ]
    },
    {
      id: 2,
      name: "Main Course",
      items: [
        { id: 201, name: "Grilled Salmon", price: 24.99, description: "Fresh salmon with lemon butter sauce" },
        { id: 202, name: "Ribeye Steak", price: 32.99, description: "12oz prime ribeye with mashed potatoes" },
        { id: 203, name: "Pasta Carbonara", price: 18.99, description: "Creamy pasta with bacon and parmesan" },
        { id: 204, name: "Chicken Curry", price: 16.99, description: "Spicy Thai curry with jasmine rice" }
      ]
    },
    {
      id: 3,
      name: "Desserts",
      items: [
        { id: 301, name: "Tiramisu", price: 8.99, description: "Classic Italian coffee-flavored dessert" },
        { id: 302, name: "Chocolate Lava Cake", price: 10.99, description: "Warm cake with molten chocolate center" },
        { id: 303, name: "Mango Sticky Rice", price: 7.99, description: "Sweet Thai dessert with coconut milk" }
      ]
    },
    {
      id: 4,
      name: "Beverages",
      items: [
        { id: 401, name: "Fresh Lemonade", price: 4.99, description: "Homemade squeezed lemonade" },
        { id: 402, name: "Iced Cappuccino", price: 5.99, description: "Espresso with cold milk and foam" },
        { id: 403, name: "House Wine", price: 8.99, description: "Red or white wine selection" }
      ]
    }
  ]
};

// GET all menu
router.get('/', (req, res) => {
  res.json({
    success: true,
    data: menu,
    count: menu.categories.length
  });
});

// GET category by ID
router.get('/category/:id', (req, res) => {
  const category = menu.categories.find(c => c.id === parseInt(req.params.id));
  if (!category) {
    return res.status(404).json({ success: false, message: 'Category not found' });
  }
  res.json({ success: true, data: category });
});

// GET item by ID
router.get('/item/:id', (req, res) => {
  let item = null;
  menu.categories.forEach(cat => {
    const found = cat.items.find(i => i.id === parseInt(req.params.id));
    if (found) item = found;
  });
  
  if (!item) {
    return res.status(404).json({ success: false, message: 'Item not found' });
  }
  res.json({ success: true, data: item });
});

module.exports = router;
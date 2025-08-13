# 🔧 Fix npm run dev Build Errors - Local Setup Guide

If you're getting Tailwind CSS PostCSS errors, follow these steps exactly:

## 🚨 The Problem
Tailwind CSS v4 has breaking changes that don't work with Laravel Mix v6. We need to use Tailwind v3.

## ✅ Step-by-Step Fix

### 1. Delete node_modules and package-lock.json
```bash
rm -rf node_modules
rm package-lock.json
```

### 2. Clear npm cache
```bash
npm cache clean --force
```

### 3. Install exact compatible versions
```bash
npm install
```

### 4. Verify Tailwind version
```bash
npx tailwindcss --version
# Should show: tailwindcss 3.3.5
```

### 5. Test build
```bash
npm run dev
```

## 🔧 Alternative Fix (if above doesn't work)

### Manual version installation:
```bash
# Remove current tailwind
npm uninstall tailwindcss

# Install specific v3 version
npm install --save-dev tailwindcss@3.3.5

# Install compatible PostCSS
npm install --save-dev postcss@8.4.31 autoprefixer@10.4.16

# Test again
npm run dev
```

## 📋 Expected Success Output
```
✔ Compiled Successfully in 800ms
┌─────────────────────┬──────────┐
│ File                │ Size     │
├─────────────────────┼──────────┤
│ /js/app.js         │ 1.26 MiB │
│ css/app.css        │ 33.4 KiB │
└─────────────────────┴──────────┘
```

## 🚀 Development Commands
```bash
npm run dev     # Build once
npm run watch   # Watch for changes  
npm run hot     # Hot reload
npm run prod    # Production build
```

## 🆘 Still Having Issues?

1. **Check Node.js version**: `node --version` (should be 16+ or 18+)
2. **Check npm version**: `npm --version` (should be 8+)
3. **Delete everything and reinstall**:
   ```bash
   rm -rf node_modules package-lock.json
   npm install
   npm run dev
   ```

This setup is tested and working! 🎯
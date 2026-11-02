const fs = require('fs');
const path = require('path');

const targetDirs = [
    path.join(__dirname, '..', 'scripts', 'pages'),
    path.join(__dirname, '..', 'dist')
];

function getAllHtmlFiles(dir, fileList = []) {
    if (!fs.existsSync(dir)) return fileList;
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const filePath = path.join(dir, file);
        const stat = fs.statSync(filePath);
        if (stat.isDirectory()) {
            getAllHtmlFiles(filePath, fileList);
        } else if (file.endsWith('.html')) {
            fileList.push(filePath);
        }
    }
    return fileList;
}

let allFiles = [];
for (const dir of targetDirs) {
    allFiles = allFiles.concat(getAllHtmlFiles(dir));
}

console.log(`Found ${allFiles.length} HTML files.`);

let updatedCount = 0;

for (const file of allFiles) {
    let content = fs.readFileSync(file, 'utf8');
    let original = content;

    // 1. Desktop dropdown trigger span
    content = content.replace(/(class="dropdown-trigger[^"]*">\s*)<span>Course Packages?<\/span>/gi, '$1<span>Package</span>');

    // 2. Desktop dropdown menu box content inside nav-dropdown
    content = content.replace(/<div class="dropdown-menu-box">[\s\S]*?<\/div>/gi, (match) => {
        return `<div class="dropdown-menu-box">
                    <a href="/buy-now?package=basic" class="dropdown-item-link">Basic</a>
                    <a href="/buy-now?package=growth" class="dropdown-item-link">Growth</a>
                    <a href="/buy-now?package=advance" class="dropdown-item-link">Advance</a>
                    <a href="/buy-now?package=premium" class="dropdown-item-link">Premium</a>
                    <a href="/buy-now?package=infinity" class="dropdown-item-link">Infinity</a>
                </div>`;
    });

    // 3. Mobile accordion button span
    content = content.replace(/(<button[^>]*class="mobile-accordion-btn"[^>]*>[\s\S]*?)<span>Course Packages?<\/span>/gi, '$1<span>Package</span>');

    // 4. Mobile accordion contents
    content = content.replace(/<div class="mobile-accordion-content" id="(mobileCoursePackageContent|websiteCoursePackageContent)">[\s\S]*?<\/div>/gi, (match, id) => {
        return `<div class="mobile-accordion-content" id="${id}">
                <a href="/buy-now?package=basic" class="mobile-sub-item">Basic</a>
                <a href="/buy-now?package=growth" class="mobile-sub-item">Growth</a>
                <a href="/buy-now?package=advance" class="mobile-sub-item">Advance</a>
                <a href="/buy-now?package=premium" class="mobile-sub-item">Premium</a>
                <a href="/buy-now?package=infinity" class="mobile-sub-item">Infinity</a>
            </div>`;
    });

    if (content !== original) {
        fs.writeFileSync(file, content, 'utf8');
        updatedCount++;
    }
}

console.log(`Updated ${updatedCount} files successfully.`);

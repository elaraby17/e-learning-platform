const CONTAINERS = [
    'video-iframe-wrapper',
    'video-native-wrapper',
    'welcome-placeholder',
    'article-container',
    'quiz-container',
];

const ACTIVE_LESSON_CLASSES = [
    'bg-brand-50',
    'dark:bg-brand-500/10',
    'border-s-4',
    'border-brand-500',
];

const TYPE_LABELS = {
    video: 'فيديو شروحات',
    article: 'قراءة ومقالة',
    quiz: 'اختبار قصير',
};

function swal() {
    return window.Swal ?? null;
}

function buildEmbedUrl(videoUrl) {
    if (/youtube\.com\/watch\?v=/.test(videoUrl)) {
        return videoUrl.replace('watch?v=', 'embed/') + '?autoplay=1&rel=0';
    }

    if (/youtu\.be\//.test(videoUrl)) {
        const id = videoUrl.split('youtu.be/')[1].split('?')[0];
        return `https://www.youtube.com/embed/${id}?autoplay=1&rel=0`;
    }

    if (/vimeo\.com/.test(videoUrl)) {
        const id = videoUrl.split('vimeo.com/')[1];
        return `https://player.vimeo.com/video/${id}?autoplay=1`;
    }

    return videoUrl;
}

export function initCoursePlayer() {
    const root = document.getElementById('course-player');

    if (!root) return;

    const completedLessons = new Set();
    let activeLessonId = null;

    const progressBar = document.getElementById('progress-bar');
    const progressLabel = document.getElementById('progress-label');

    function updateProgressBar() {
        const totalLessons = root.querySelectorAll('[data-lesson-trigger]').length;
        if (!totalLessons || !progressBar || !progressLabel) return;

        const percentage = Math.round((completedLessons.size / totalLessons) * 100);
        progressBar.style.width = `${percentage}%`;
        progressLabel.textContent = `${percentage}%`;
    }

    function toggleSection(sectionId, trigger) {
        const target = document.getElementById(sectionId);
        if (!target) return;

        const icon = document.getElementById(`icon-${sectionId}`);
        const isHidden = target.classList.toggle('hidden');

        if (icon) {
            icon.style.transform = isHidden ? 'rotate(-90deg)' : 'rotate(0deg)';
        }

        trigger?.setAttribute('aria-expanded', String(!isHidden));
    }

    function showContainer(id) {
        CONTAINERS.forEach((containerId) => {
            document.getElementById(containerId)?.classList.add('hidden');
        });

        document.getElementById(id)?.classList.remove('hidden');
    }

    function renderVideo(videoUrl) {
        const embedUrl = buildEmbedUrl(videoUrl);
        const isEmbed = /youtube\.com\/embed|vimeo\.com\/video/.test(embedUrl);

        if (isEmbed) {
            const iframe = document.getElementById('video-player-iframe');
            if (iframe) {
                iframe.src = embedUrl;
                showContainer('video-iframe-wrapper');
                return;
            }
        }

        const native = document.getElementById('video-player-native');
        if (native) {
            native.src = videoUrl;
            native.load();
            showContainer('video-native-wrapper');
        }
    }

    function selectLesson(trigger) {
        if (!trigger) return;

        root.querySelectorAll('[data-lesson-trigger]').forEach((button) => {
            button.classList.remove(...ACTIVE_LESSON_CLASSES);
            button.setAttribute('aria-current', 'false');
        });

        trigger.classList.add(...ACTIVE_LESSON_CLASSES);
        trigger.setAttribute('aria-current', 'true');

        activeLessonId = trigger.dataset.id;

        const title = trigger.dataset.title ?? '';
        const type = trigger.dataset.type ?? 'video';
        const videoUrl = trigger.dataset.videoUrl ?? '';
        const content = trigger.dataset.content || 'لا يوجد محتوى نصي لهذا الدرس حالياً.';

        const titleEl = document.getElementById('active-lesson-title');
        const metaEl = document.getElementById('active-lesson-meta');
        const completeBtn = document.getElementById('btn-complete-lesson');

        if (titleEl) titleEl.textContent = title;
        if (metaEl) metaEl.textContent = `نوع المحتوى: ${TYPE_LABELS[type] ?? TYPE_LABELS.video}`;
        completeBtn?.classList.remove('hidden');

        if (type === 'article') {
            const articleTitle = document.getElementById('article-title');
            const articleContent = document.getElementById('article-content');

            if (articleTitle) articleTitle.textContent = title;
            if (articleContent) articleContent.textContent = content;

            showContainer('article-container');
        } else if (type === 'quiz') {
            const quizTitle = document.getElementById('quiz-title');
            const quizPreview = document.getElementById('quiz-content-preview');

            if (quizTitle) quizTitle.textContent = title;

            if (quizPreview) {
                quizPreview.replaceChildren();

                const heading = document.createElement('strong');
                heading.textContent = 'تعليمات الاختبار:';
                quizPreview.append(heading);

                ['هذا الاختبار مخصص لتطبيق ما تم شرحه.', 'ركّز في إجاباتك واقرأ كل سؤال جيداً.'].forEach(
                    (instruction, index) => {
                        const item = document.createElement('p');
                        item.className = 'mt-1';
                        item.textContent = `${index + 1}. ${instruction}`;
                        quizPreview.append(item);
                    },
                );

                const summary = document.createElement('p');
                summary.className =
                    'mt-3 border-t border-slate-200 pt-3 opacity-70 dark:border-navy-border';
                summary.textContent = `ملخص الدرس: ${content}`;
                quizPreview.append(summary);
            }

            showContainer('quiz-container');
        } else {
            renderVideo(videoUrl);
        }

        if (window.innerWidth < 1024) {
            document.getElementById('main-viewer-card')?.scrollIntoView({ behavior: 'smooth' });
        }
    }

    function markAsCompleted() {
        if (!activeLessonId) return;

        const dialog = swal();

        if (!dialog) return;

        if (completedLessons.has(activeLessonId)) {
            dialog.fire({
                icon: 'info',
                title: 'تم الإكمال مسبقاً',
                text: 'لقد قمت بتحديد هذا الدرس كمكتمل من قبل.',
                confirmButtonText: 'حسناً',
                timer: 2500,
                timerProgressBar: true,
            });
            return;
        }

        dialog
            .fire({
                icon: 'success',
                title: 'أحسنت! 🎉',
                text: 'تم تحديد هذا الدرس كمكتمل. استمر في التقدم!',
                confirmButtonText: 'التالي',
                confirmButtonColor: '#10b981',
                timer: 3000,
                timerProgressBar: true,
            })
            .then(() => {
                completedLessons.add(activeLessonId);

                const statusIcon = root.querySelector(`.lesson-status-${activeLessonId} i`);
                if (statusIcon) {
                    statusIcon.classList.remove('far', 'fa-circle');
                    statusIcon.classList.add('fas', 'fa-circle-check', 'text-success-500');
                }

                updateProgressBar();
            });
    }

    function startQuizConfirm() {
        const dialog = swal();

        if (!dialog) return;

        dialog
            .fire({
                title: 'هل أنت مستعد؟',
                text: 'بمجرد البدء لن تتمكن من إيقاف الاختبار. تأكد من جهوزيتك!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ابدأ الاختبار',
                cancelButtonText: 'ليس الآن',
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    dialog.fire({
                        icon: 'info',
                        title: 'جاري تحميل الأسئلة...',
                        text: 'ركّز وحل بكل دقة. بالتوفيق! 💪',
                        confirmButtonText: 'حسناً',
                    });
                }
            });
    }

    root.addEventListener('click', (event) => {
        const sectionTrigger = event.target.closest('[data-toggle-section]');
        if (sectionTrigger) {
            toggleSection(sectionTrigger.dataset.toggleSection, sectionTrigger);
            return;
        }

        const lessonTrigger = event.target.closest('[data-lesson-trigger]');
        if (lessonTrigger) {
            selectLesson(lessonTrigger);
            return;
        }

        if (event.target.closest('[data-complete-lesson]')) {
            markAsCompleted();
            return;
        }

        if (event.target.closest('[data-quiz-start]')) {
            startQuizConfirm();
        }
    });

    if (root.dataset.autoplay === 'true') {
        const current = root.querySelector('[data-lesson-trigger][aria-current="true"]');
        const fallback = root.querySelector('[data-lesson-trigger]');

        selectLesson(current ?? fallback);
    }
}

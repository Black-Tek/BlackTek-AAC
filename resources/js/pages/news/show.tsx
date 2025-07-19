import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, NewsItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface ShowProps {
    news: NewsItem;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
    {
        title: 'News',
        href: '/news',
    },
];

export default function Show({ news }: ShowProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={news.title} />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="pt-12">
                    {/* Article content */}
                    <article className="mx-auto max-w-4xl">
                        {/* Article header */}
                        <header className="mb-8 pb-8">
                            <div className="mb-4">
                                <time className="text-sm text-zinc-500 dark:text-zinc-400" dateTime={news.published_at}>
                                    {new Date(news.published_at).toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit',
                                    })}
                                </time>
                            </div>
                            <h1 className="text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl dark:text-white">{news.title}</h1>
                        </header>

                        {/* Article body */}
                        <div className="prose prose-lg dark:prose-invert max-w-none">
                            <div
                                className="leading-relaxed whitespace-pre-wrap text-gray-600 dark:text-gray-300"
                                dangerouslySetInnerHTML={{ __html: news.content }}
                            />
                        </div>

                        {/* Article footer */}
                        <footer className="mt-12 border-t border-zinc-200 pt-8 dark:border-zinc-700">
                            <div className="flex items-center justify-between">
                                <div className="text-sm text-zinc-500 dark:text-zinc-400">
                                    Published on{' '}
                                    {new Date(news.published_at).toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                    })}
                                </div>
                                <Link
                                    href="/news"
                                    className="inline-flex items-center rounded-md bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-900 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700"
                                >
                                    View all news
                                </Link>
                            </div>
                        </footer>
                    </article>
                </div>
            </div>
        </AppLayout>
    );
}

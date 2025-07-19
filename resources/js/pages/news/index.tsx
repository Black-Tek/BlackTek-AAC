import AppLayout from '@/layouts/app-layout';
import type { BreadcrumbItem, NewsItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface IndexProps {
    news: NewsItem[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/',
    },
];

export default function Index({ news }: IndexProps) {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="News" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <div className="pt-12">
                    <div className="mx-auto max-w-4xl">
                        {news.map((item) => (
                            <article className="mb-12 border-b border-zinc-200 pb-8 last:border-b-0 dark:border-zinc-700" key={item.id}>
                                {/* Article header */}
                                <header className="mb-8 pb-8">
                                    <div className="mb-4">
                                        <time className="text-sm text-zinc-500 dark:text-zinc-400" dateTime={item.published_at}>
                                            {new Date(item.published_at).toLocaleDateString('en-US', {
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric',
                                            })}
                                        </time>
                                    </div>
                                    <Link href={route('news.show', item.id)}>
                                        <h1 className="text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl dark:text-white">{item.title}</h1>
                                    </Link>
                                </header>

                                {/* Article preview */}
                                <div className="prose prose-lg dark:prose-invert max-w-none">
                                    <div className="leading-relaxed text-zinc-600 dark:text-zinc-300">
                                        {item.content.length > 300 ? (
                                            <>
                                                <div
                                                    className="whitespace-pre-wrap"
                                                    dangerouslySetInnerHTML={{ __html: item.content.substring(0, 300) + '...' }}
                                                />
                                                <div className="mt-4">
                                                    <Link
                                                        href={route('news.show', item.id)}
                                                        className="inline-flex items-center rounded-md bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-900 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-100 dark:hover:bg-zinc-700"
                                                    >
                                                        Read more →
                                                    </Link>
                                                </div>
                                            </>
                                        ) : (
                                            <div className="whitespace-pre-wrap" dangerouslySetInnerHTML={{ __html: item.content }} />
                                        )}
                                    </div>
                                </div>
                            </article>
                        ))}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}

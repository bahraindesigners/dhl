import NavbarLayout from '@/layouts/navbar-layout';
import { Head, Link, usePage } from '@inertiajs/react';
import { useTranslation } from 'react-i18next';
import { type SharedData, Blog } from '@/types';
import { Calendar, User, Clock, Eye, Share2, BookOpen, X } from 'lucide-react';
import PhotoSwipeLightbox from 'photoswipe/lightbox';
import 'photoswipe/style.css';
import { useState, useEffect, useRef } from 'react';
import BlogCard from './components/BlogCard';

interface BlogShowProps {
    blog: Blog;
    relatedBlogs: Blog[];
}

export default function BlogShow() {
    const { blog, relatedBlogs } = usePage<SharedData & BlogShowProps>().props;
    const { t, i18n } = useTranslation();
    const isRTL = i18n.language === 'ar';
    const galleryRef = useRef<HTMLDivElement>(null);

    // Helper function to render content - handles both HTML strings and TipTap JSON
    const tiptapToHtml = (tiptapJson: any): string => {
        if (typeof tiptapJson === 'string') {
            return tiptapJson;
        }

        if (!tiptapJson || !tiptapJson.content) {
            return '';
        }

        const processNode = (node: any): string => {
            if (node.type === 'paragraph') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                if (!content.trim()) {
                    return '<p><br></p>'; // Preserve empty paragraphs for line breaks
                }
                return `<p>${content}</p>`;
            }

            if (node.type === 'text') {
                return node.text || '';
            }

            if (node.type === 'heading') {
                const level = node.attrs?.level || 1;
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<h${level}>${content}</h${level}>`;
            }

            if (node.type === 'bulletList') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<ul>${content}</ul>`;
            }

            if (node.type === 'orderedList') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<ol>${content}</ol>`;
            }

            if (node.type === 'listItem') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<li>${content}</li>`;
            }

            if (node.type === 'blockquote') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<blockquote>${content}</blockquote>`;
            }

            if (node.type === 'codeBlock') {
                const content = node.content ? node.content.map(processNode).join('') : '';
                return `<pre><code>${content}</code></pre>`;
            }

            // For unknown nodes, try to process their content
            if (node.content) {
                return node.content.map(processNode).join('');
            }

            return '';
        };

        return tiptapJson.content.map(processNode).join('');
    };

    const formatDate = (dateString: string) => {
        const date = new Date(dateString);
        return new Intl.DateTimeFormat(i18n.language, {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        }).format(date);
    };

    // Helper function to render content - used by BlogCard
    const renderContent = (content: any): string => {
        if (typeof content === 'string') {
            return content;
        }
        if (typeof content === 'object' && content !== null) {
            return content[i18n.language] || content.en || '';
        }
        return '';
    };

    const contentHtml = tiptapToHtml(blog.content);

    // Initialize PhotoSwipe
    useEffect(() => {
        if (!galleryRef.current || !blog.gallery || blog.gallery.length === 0) return;

        const lightbox = new PhotoSwipeLightbox({
            gallery: galleryRef.current,
            children: 'a',
            pswpModule: () => import('photoswipe'),
            showHideOpacity: true,
            bgOpacity: 0.9,
            spacing: 0.1,
            allowPanToNext: false,
            zoom: true,
            close: true,
            arrowKeys: true,
            returnFocus: false,
            wheelToZoom: true,
            clickToCloseNonZoomable: false,
            closeOnVerticalDrag: true,
            padding: { top: 20, bottom: 40, left: 100, right: 100 },
            imageClickAction: 'zoom',
            tapAction: 'zoom',
            doubleTapAction: 'zoom',
        });

        lightbox.init();

        return () => {
            lightbox.destroy();
        };
    }, [blog.gallery]);

    // Helper function to get category badge styles
    const getCategoryBadgeStyles = () => {
        if (!blog.blog_category?.color) {
            return {
                backgroundColor: 'rgba(107, 114, 128, 0.1)', // gray-500 with 10% opacity
                color: '#6b7280' // gray-500 full opacity
            };
        }

        const color = blog.blog_category.color;

        // Convert hex color to rgba with 10% opacity for background
        const hexToRgba = (hex: string, opacity: number) => {
            const cleanHex = hex.replace('#', '');
            const r = parseInt(cleanHex.substr(0, 2), 16);
            const g = parseInt(cleanHex.substr(2, 2), 16);
            const b = parseInt(cleanHex.substr(4, 2), 16);
            return `rgba(${r}, ${g}, ${b}, ${opacity})`;
        };

        return {
            backgroundColor: hexToRgba(color, 0.1), // 10% opacity background
            color: color // Full opacity text
        };
    };

    return (
        <NavbarLayout>
            <Head title={typeof blog.title === 'string' ? blog.title : blog.title[i18n.language] || blog.title.en} />

            <div className="bg-white">
                {/* Hero Section */}
                <div className="relative bg-gradient-to-b from-slate-50 to-white">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                        <div className="max-w-4xl mx-auto">


                            {/* Category Badge */}
                            {blog.blog_category && (
                                <div className="mb-6">
                                    <span
                                        className="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                        style={getCategoryBadgeStyles()}
                                    >
                                        {typeof blog.blog_category.name === 'string'
                                            ? blog.blog_category.name
                                            : blog.blog_category.name[i18n.language] || blog.blog_category.name.en}
                                    </span>
                                </div>
                            )}

                            {/* Title */}
                            <h1 className="text-4xl md:text-5xl font-bold text-slate-900 mb-6 leading-tight">
                                {typeof blog.title === 'string' ? blog.title : blog.title[i18n.language] || blog.title.en}
                            </h1>

                            {/* Excerpt */}
                            {blog.excerpt && (
                                <p className="text-xl text-slate-600 mb-8 leading-relaxed">
                                    {typeof blog.excerpt === 'string' ? blog.excerpt : blog.excerpt[i18n.language] || blog.excerpt.en}
                                </p>
                            )}

                            {/* Meta Information */}
                            <div className="flex flex-wrap items-center gap-6 text-slate-600">
                                <div className="flex items-center gap-2">
                                    <User className="h-4 w-4" />
                                    <span>{blog.author}</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <Calendar className="h-4 w-4" />
                                    <span>{formatDate(blog.published_at)}</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <Clock className="h-4 w-4" />
                                    <span>{blog.reading_time} {t('blog.minRead', 'min_read')}</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <Eye className="h-4 w-4" />
                                    <span>{blog.views_count} {t('blog.views', 'views')}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Featured Image */}
                {blog.featured_image && (
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 mb-16">
                        <div className="max-w-4xl mx-auto">
                            <div className="relative aspect-video rounded-2xl overflow-hidden shadow-xl">
                                <img
                                    src={blog.featured_image}
                                    alt={typeof blog.title === 'string' ? blog.title : blog.title[i18n.language] || blog.title.en}
                                    className="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                    </div>
                )}

                {/* Main Content */}
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                    <div className="max-w-4xl mx-auto">
                        {/* Article Content */}
                        <div className="prose prose-lg max-w-none prose-slate">
                            <div
                                className="tiptap-content"
                                dangerouslySetInnerHTML={{ __html: contentHtml }}
                            />
                        </div>

                        {/* Gallery Section */}
                        {blog.gallery && blog.gallery.length > 0 && (
                            <div className="mt-16">
                                <h3 className="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                                    <BookOpen className="h-6 w-6" />
                                    {t('blog.gallery', 'Gallery')}
                                </h3>

                                {/* Gallery Grid */}
                                <div
                                    ref={galleryRef}
                                    className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
                                >
                                    {blog.gallery.map((image, index) => (
                                        <a
                                            key={image.id}
                                            href={image.url}
                                            data-pswp-alt={image.alt}
                                            data-pswp-width={image.width}
                                            data-pswp-height={image.height}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="group relative aspect-square cursor-pointer overflow-hidden rounded-lg bg-slate-100 hover:shadow-lg transition-all duration-200 block"
                                        >
                                            <img
                                                src={image.thumb || image.url}
                                                alt={image.alt}
                                                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                                                onError={(e) => {
                                                    // Fallback to original URL if thumb fails
                                                    const target = e.target as HTMLImageElement;
                                                    if (target.src !== image.url) {
                                                        target.src = image.url;
                                                    }
                                                }}
                                            />
                                            <div className="absolute inset-0 hover:bg-black/50 bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 flex items-center justify-center">
                                                <div className="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <div className="w-12 h-12 bg-white bg-opacity-90 rounded-full flex items-center justify-center">
                                                        <Eye className="w-6 h-6 text-slate-700" />
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    ))}
                                </div>

                                <p className="text-sm text-slate-600 mt-4 text-center">
                                    {t('blog.clickToEnlarge', 'Click on any image to view in full size')}
                                </p>
                            </div>
                        )}
                    </div>
                </div>

                {/* Related Articles */}
                {relatedBlogs.length > 0 && (
                    <div className="bg-slate-50">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                            <div className="max-w-4xl mx-auto">
                                <h2 className="text-3xl font-bold text-slate-900 mb-8">
                                    {t('related_articles', 'Related Articles')}
                                </h2>
                                <div className="grid md:grid-cols-3 gap-8">
                                    {relatedBlogs.map((relatedBlog, index) => (
                                        <BlogCard
                                            key={relatedBlog.id}
                                            blog={relatedBlog}
                                            index={index}
                                            renderContent={renderContent}
                                            formatDate={formatDate}
                                        />
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                )}
            </div>

            <style>{`
                .tiptap-content h1,
                .tiptap-content h2,
                .tiptap-content h3,
                .tiptap-content h4,
                .tiptap-content h5,
                .tiptap-content h6 {
                    font-weight: 600;
                    color: #1e293b;
                    margin-top: 2rem;
                    margin-bottom: 1rem;
                    line-height: 1.3;
                }

                .tiptap-content h1 { font-size: 2.25rem; }
                .tiptap-content h2 { font-size: 1.875rem; }
                .tiptap-content h3 { font-size: 1.5rem; }
                .tiptap-content h4 { font-size: 1.25rem; }
                .tiptap-content h5 { font-size: 1.125rem; }
                .tiptap-content h6 { font-size: 1rem; }

                .tiptap-content p {
                    margin-bottom: 1.5rem;
                    line-height: 1.7;
                    color: #475569;
                }

                .tiptap-content ul,
                .tiptap-content ol {
                    margin: 1.5rem 0;
                    padding-left: 2rem;
                }

                .tiptap-content li {
                    margin-bottom: 0.5rem;
                    line-height: 1.7;
                    color: #475569;
                }

                .tiptap-content blockquote {
                    border-left: 4px solid #3b82f6;
                    padding-left: 1.5rem;
                    margin: 2rem 0;
                    font-style: italic;
                    color: #64748b;
                    background: #f8fafc;
                    padding: 1.5rem;
                    border-radius: 0.5rem;
                }

                .tiptap-content pre {
                    background: #1e293b;
                    color: #e2e8f0;
                    padding: 1.5rem;
                    border-radius: 0.75rem;
                    overflow-x: auto;
                    margin: 2rem 0;
                }

                .tiptap-content code {
                    background: #f1f5f9;
                    color: #475569;
                    padding: 0.25rem 0.5rem;
                    border-radius: 0.25rem;
                    font-size: 0.875rem;
                }

                .tiptap-content pre code {
                    background: none;
                    color: inherit;
                    padding: 0;
                }

                /* Custom styles for PhotoSwipe */
                .pswp {
                    z-index: 9999;
                }

                .pswp__bg {
                    background: rgba(0, 0, 0, 0.9);
                }

                .pswp__top-bar {
                    background: transparent;
                }

                .pswp__button {
                    background: transparent !important;
                    border: none;
                    box-shadow: none;
                    transition: all 0.2s;
                }

                .pswp__button:hover {
                    background: transparent !important;
                    opacity: 0.7;
                }

                .pswp__button--close {
                    top: 20px;
                    right: 20px;
                }

                .pswp__button--zoom {
                    top: 20px;
                    right: 80px;
                }

                .pswp__button--arrow--left,
                .pswp__button--arrow--right {
                    background: transparent !important;
                }

                .pswp__button--arrow--left:hover,
                .pswp__button--arrow--right:hover {
                    background: transparent !important;
                    opacity: 0.7;
                }

                /* Grid hover effects */
                .gallery-grid-item:hover .gallery-overlay {
                    opacity: 1;
                }

                .gallery-overlay {
                    opacity: 0;
                    transition: opacity 0.2s ease-in-out;
                }
            `}</style>
        </NavbarLayout>
    );
}
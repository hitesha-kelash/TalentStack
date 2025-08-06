import type { Metadata } from "next";
import { Geist, Geist_Mono } from "next/font/google";
import "./globals.css";
import { Toaster } from "@/components/ui/sonner";
import { SessionProvider } from "next-auth/react";

// Load fonts
const geistSans = Geist({
  variable: "--font-geist-sans",
  subsets: ["latin"],
  display: "swap", // Optimize font display
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: ["latin"],
  display: "swap",
});

// Comprehensive metadata for SEO
export const metadata: Metadata = {
  title: {
    template: "FreeFlow - Freelancer Platform",
    default:
      "FreeFlow - Portfolio, Client Management & Payment Platform for Freelancers",
  },
  description:
    "All-in-one platform for freelancers to showcase work, manage clients, track time, and process payments effortlessly. Build your business with FreeFlow.",
  keywords: [
    "freelancer platform",
    "portfolio builder",
    "client management",
    "invoice tools",
    "time tracking",
    "freelance payment",
    "professional portfolio",
  ],
  authors: [{ name: "FreeFlow Team" }],
  creator: "FreeFlow Inc.",
  publisher: "FreeFlow Inc.",
  formatDetection: {
    email: false,
    address: false,
    telephone: false,
  },
  metadataBase: new URL("https://freeflowapp.vercel.app/"),
  alternates: {
    canonical: "/",
  },
  openGraph: {
    title:
      "FreeFlow - Portfolio, Client Management & Payment Platform for Freelancers",
    description:
      "Showcase your work, manage clients, and get paid—all in one place. Built for freelancers, by freelancers.",
    url: "https://freeflowapp.vercel.app/",
    siteName: "FreeFlow",
    locale: "en_US",
    type: "website",
    images: [
      {
        url: "https://freeflowapp.vercel.app/opengraph-image.png",
        width: 1200,
        height: 630,
        alt: "FreeFlow Platform",
      },
    ],
  },
  twitter: {
    card: "summary_large_image",
    title:
      "FreeFlow - Portfolio, Client Management & Payment Platform for Freelancers",
    description:
      "Showcase your work, manage clients, and get paid—all in one place. Built for freelancers, by freelancers.",
    creator: "@AnkitMishraexe",
    images: ["https://freeflowapp.vercel.app/freeflow-twitter.jpg"],
  },
  robots: {
    index: true,
    follow: true,
    googleBot: {
      index: true,
      follow: true,
      "max-video-preview": -1,
      "max-image-preview": "large",
      "max-snippet": -1,
    },
  },
  verification: {
    google: "verification_token",
    yandex: "verification_token",
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" className="scroll-smooth">
      <head>
        <link rel="icon" href="/favicon.ico" sizes="any" />
        <link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <link rel="manifest" href="/site.webmanifest" />
      </head>
      <body
        className={`${geistSans.variable} ${geistMono.variable} antialiased dark min-h-screen flex flex-col`}
      >
        <SessionProvider>
          <main className="flex-grow">{children}</main>
          <Toaster richColors />
        </SessionProvider>
      </body>
    </html>
  );
}

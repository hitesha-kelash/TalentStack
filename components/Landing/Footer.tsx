import { Flower } from "lucide-react";
import Link from "next/link";
import MaxWidthWrapper from "../Shared/maxWidthWrapper";

export default function Footer() {
  return (
    <footer className="w-full py-10 bg-gradient-to-b  text-gray-100 border-t border-gray-800">
      <MaxWidthWrapper>
        <div className="container px-4 md:px-6 mx-auto">
          <div className="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
            {/* Brand/Logo Section */}
            <div className="flex flex-col items-center md:items-start">
              <div className="logo flex justify-center align-middle items-center">
                <Link
                  className="flex justify-center align-middle items-center gap-2"
                  href={"/"}
                >
                  <Flower className="" size={40} color="#b78bf2" />{" "}
                  <span className="text-high text-2xl">FreeFlow</span>
                </Link>
              </div>
              <p className="mt-1 text-sm text-gray-400">
                Your freelance business, simplified.
              </p>
            </div>

            {/* Navigation Links */}
            <nav className="flex flex-wrap justify-center gap-x-8 gap-y-4 text-sm font-medium">
              <div className="flex flex-col items-center md:items-start space-y-2">
                <p className="text-high text-xs uppercase tracking-wider mb-1">
                  Main
                </p>
                <div className="flex flex-row md:flex-col space-x-4 md:space-x-0 md:space-y-2">
                  <Link href="/" className="hover:text-high transition-colors">
                    Home
                  </Link>
                  <Link
                    href="/features"
                    className="hover:text-high transition-colors"
                  >
                    Features
                  </Link>
                  <Link
                    href="/pricing"
                    className="hover:text-high transition-colors"
                  >
                    Pricing
                  </Link>
                  <Link
                    href="/contact"
                    className="hover:text-high transition-colors"
                  >
                    Contact
                  </Link>
                </div>
              </div>
              <div className="flex flex-col items-center md:items-start space-y-2">
                <p className="text-high text-xs uppercase tracking-wider mb-1">
                  Legal
                </p>
                <div className="flex flex-row md:flex-col space-x-4 md:space-x-0 md:space-y-2">
                  <Link
                    href="/terms"
                    className="hover:text-high transition-colors"
                  >
                    Terms
                  </Link>
                  <Link
                    href="/privacy"
                    className="hover:text-high transition-colors"
                  >
                    Privacy
                  </Link>
                </div>
              </div>
            </nav>

            {/* Copyright */}
            <div className="text-sm text-gray-400 text-center md:text-right">
              © 2025 FreelancerHub. All rights reserved.
            </div>
          </div>
        </div>
      </MaxWidthWrapper>
    </footer>
  );
}

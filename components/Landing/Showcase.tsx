import Image from "next/image";
import { Download, Mail } from "lucide-react";
import userImage from "@/public/MyImage-removebg-preview.png";

export default function Showcase() {
  return (
    <div className="min-h-screen  text-high p-4 md:p-8">
      <div className="max-w-7xl mx-auto">
        <div className="text-center mb-12">
          <h1 className="text-4xl md:text-5xl font-bold mb-4">
            All-in-One Freelancer Platform
          </h1>
          <p className="text-xl text-gray-400 max-w-3xl mx-auto">
            Everything you need to manage your freelance business in one place -
            from showcasing work to getting paid.
          </p>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {/* Portfolio Section */}
          <div className="bg-[#141419] rounded-3xl p-6 flex flex-col">
            <h2 className="text-3xl font-bold text-center mb-2">
              Showcase Your
            </h2>
            <h2 className="text-3xl font-bold text-center mb-6">Best Work</h2>

            <p className="text-center text-gray-300 mb-8">
              Create a personalized portfolio that looks great on any device.
              Impress clients with projects that speak for themselves.
            </p>

            <div className="mt-auto">
              <div className="bg-[#1a1a20] rounded-2xl p-4 drop-shadow-2xl drop-shadow-black">
                <div className="flex items-center mb-4">
                  <div className="relative  mr-3">
                    <Image
                      src={userImage}
                      alt="Profile"
                      width={540}
                      height={540}
                      className="rounded-full object-cover h-10 w-10 "
                    />
                  </div>
                  <div>
                    <p className="font-medium">Ankit Mishra</p>
                    <p className="text-xs text-gray-400">@ankitmishra</p>
                  </div>
                </div>

                <p className="text-sm font-medium mb-2">Website Redesign</p>

                <div className="flex justify-between text-xs mb-2">
                  <span>Mobile App</span>
                  <span>Brand Identity</span>
                </div>

                <div className="grid grid-cols-2 gap-3 mb-3">
                  <div className="aspect-square rounded-xl bg-[#222228] flex items-center justify-center">
                    <div className="w-10 h-3 bg-gray-500 rounded-full"></div>
                  </div>
                  <div className="aspect-square rounded-xl bg-[#222228] flex items-center justify-center">
                    <div className="w-0 h-0 border-l-8 border-l-transparent border-b-8 border-b-gray-500 border-r-8 border-r-transparent"></div>
                  </div>
                </div>

                <div className="flex justify-between text-xs">
                  <span>Brand Identity</span>
                  <span>Contaition</span>
                </div>
              </div>
            </div>
          </div>

          {/* Time Tracking Section */}
          <div className="bg-[#141419] rounded-3xl p-6 flex flex-col">
            <h2 className="text-3xl font-bold text-center mb-2">Track Time</h2>
            <h2 className="text-3xl font-bold text-center mb-6">Like a Pro</h2>

            <p className="text-center text-gray-300 mb-8">
              Stay on top of your work hours with built-in time tracking.
              Whether you bill hourly or need focus insights, we&apos;ve got you
              covered.
            </p>

            <div className="mt-auto">
              <div className="bg-[#1a1a20] rounded-2xl p-4 drop-shadow-2xl drop-shadow-black">
                <p className="text-lg font-medium mb-4">Design Exploration</p>

                <div className="flex items-center justify-between mb-8">
                  <div className="text-5xl font-bold">05:17:23</div>
                </div>

                <p className="text-sm text-gray-400 mb-3">Today</p>

                <div className="space-y-3">
                  <div className="flex items-center justify-between">
                    <div className="flex items-center">
                      <span className="text-xs text-gray-400 mr-3">TODAY</span>
                      <span>Research</span>
                    </div>
                    <span>2:25</span>
                  </div>

                  <div className="flex items-center justify-between">
                    <div className="flex items-center">
                      <span className="text-sm mr-3">10:30</span>
                      <span>Client Meeting</span>
                    </div>
                    <span>1:00-1:30</span>
                  </div>

                  <div className="flex items-center justify-between pt-3 border-t border-gray-700">
                    <div className="flex items-center">
                      <span>Total</span>
                    </div>
                    <div className="flex items-center">
                      <span className="text-xs text-gray-400 mr-3">
                        USTOTAL
                      </span>
                      <span>1,000:00</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Invoice Section */}
          <div className="bg-[#141419] rounded-3xl p-6 flex flex-col">
            <h2 className="text-3xl font-bold text-center mb-6">
              Get Paid Faster
            </h2>

            <p className="text-center text-gray-300 mb-8">
              Create and send invoices in seconds. Add your branding, track
              payments, and say goodbys to awkward follow-ups.
            </p>

            <div className="mt-auto">
              <div className="bg-[#1a1a20] rounded-2xl p-4 drop-shadow-2xl drop-shadow-black">
                <div className="flex items-center justify-between mb-4">
                  <h3 className="text-xl font-bold">INVOICE</h3>
                  <div className="flex space-x-2">
                    <button className="bg-[#222228] hover:bg-[#2a2a32] w-10 h-10 rounded-lg flex items-center justify-center">
                      <Download className="w-5 h-5" />
                    </button>
                    <button className="bg-[#222228] hover:bg-[#2a2a32] w-10 h-10 rounded-lg flex items-center justify-center">
                      <Mail className="w-5 h-5" />
                    </button>
                  </div>
                </div>

                <div className="mb-4">
                  <h4 className="font-medium">Smith Agency</h4>
                  <p className="text-sm text-gray-400">Web Design</p>
                </div>

                <div className="grid grid-cols-3 text-sm text-gray-400 mb-2">
                  <span>Items</span>
                  <span>Hours</span>
                  <span>Amount</span>
                </div>

                <div className="space-y-2 mb-4">
                  <div className="grid grid-cols-3 text-sm">
                    <span>Design Services</span>
                    <span>20:00</span>
                    <span>$1,000:00</span>
                  </div>
                  <div className="grid grid-cols-3 text-sm">
                    <span>Design Services</span>
                    <span>2:00</span>
                    <span>$50:00</span>
                  </div>
                </div>

                <div className="grid grid-cols-3 text-sm pt-3 border-t border-gray-700">
                  <span>Subtotal</span>
                  <span>1,000.0</span>
                  <span>$1,000:00</span>
                </div>

                <div className="grid grid-cols-3 text-sm pt-3 items-center">
                  <span>Total</span>
                  <span></span>
                  <div className="flex items-center justify-between">
                    <span className="bg-[#1a5a3a] text-[#4ade80] px-3 py-1 rounded-lg text-sm font-medium">
                      PAID
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
